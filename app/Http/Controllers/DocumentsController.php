<?php

namespace App\Http\Controllers;

use AWS;
use App\Clients;
use App\Document;
use App\Measurer;
use Carbon\Carbon;
use App\Http\Requests\SaveDocumentRequest;

class DocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('print');
    }

    public function index()
    {
        return view('documents.index',[
            'documents' => Document::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'clients' => Clients::select('id', 'name')->whereNotNull('measurer_id')->get(),
        ]);
    }

    public function store(SaveDocumentRequest $request)
    {
        // Se obtiene el cliente capturado
        $client = Clients::findOrFail($request->client_id);
        // Se calcula el día de pago a partir de la fecha de captura
        $payment_date = Carbon::create($request->date)->addDays(20);
        // Guarda la foto y asigna la ruta
        $photo = $request->file('photo')->store('images');
        // Consumo del mes
        $month_quantity = $request->final_quantity - $client->measurer->actual_measure;
        // Importe total del mes
        $total = $month_quantity * 2.5;
        // Guarda todos los calores en un array
        $data = [
            'client_id' => $request->client_id,
            'date' => $request->date,
            'payment_date' => $payment_date,
            'final_quantity' => $request->final_quantity,
            'start_quantity' => $client->measurer->actual_measure,
            'month_quantity' => $month_quantity,
            'period' => Carbon::create($request->date)->subMonth()->isoFormat('MMMM, Y'),
            'total' => $total,
            'pending' => $total,
            'photo' => $photo,
        ];
        // Crea el documento a partir de array
        $document = Document::create($data);
        // Crear la referencia de pago
        $reference = $payment_date->format('Ym') . str_pad($document->id, 4, '0', STR_PAD_LEFT);
        $document->reference = $reference;
        $document->save();
        // Obtener el id del medidor usado y actualiza su valor
        $measurer = Measurer::findOrFail($client->measurer->id);
        $measurer->actual_measure = $request->final_quantity;
        $measurer->save();

        return redirect()->route('documents.create')
            ->with('message', 'Lectura capturada correctamente.');
    }

    public function show(Document $document)
    {
        $historic = Document::select('id', 'period', 'month_quantity')
            ->where([
                ['client_id', $document->client_id],
                ['id', '<=', $document->id]
            ])->orderByDesc('id')->get();

        return view('documents.show', [
            'document' => $document,
            'historic' => $historic->take(6),
        ]);
    }

    public function authorize_docto($id)
    {
        $docto = Document::findOrFail($id);
        $docto->status = 2;
        $docto->save();

        $phone_number = $docto->client->country_code . $docto->client->phone;

        $sms = AWS::createClient('sns');
        $sms->publish([
            'Message' => 'Estimado cliente, se ha generado su recibo de servicio de gas y se ha enviado a su correo electrónico registrado.',
            'PhoneNumber' => $phone_number,
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType'  => [
                    'DataType'    => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],
        ]);

        return redirect()->route('documents.index');
    }

    public function cancel($id)
    {
        $docto = Document::findOrFail($id);
        $docto->status = 3;
        $docto->pending = 0;
        $docto->save();

        return back();
    }

    public function print($id)
    {
        $docto = Document::findOrFail($id);

        // Se obtiene los históricos de meses anteriores
        $historic = Document::select('id', 'period', 'month_quantity')
            ->where([
            ['client_id', $docto->client_id],
            ['id', '<=', $docto->id]
            ])->orderByDesc('id')->get();

        // Se arma el array para el histórico
        $arr_period = '[';
        $arr_data = '[';
        foreach ($historic->take(6) as $h)
        {
            $arr_period = $arr_period . '"' . $h->period . '",';
            $arr_data = $arr_data . $h->month_quantity . ',';
        }
        $arr_period = $arr_period . ']';
        $arr_data = $arr_data . ']';

        // Generar los valores de la gráfica
        $chart = "{
        type: 'bar',
        data: {
            labels: ". $arr_period .",
            datasets: [{
                'backgroundColor': 'rgba(169,169,169, 0.5)',
                label: 'Consumos', data: ". $arr_data ."}
                ]}
            }";

        // General el PDF
        $pdf = \PDF::loadView('print.document', [
            'docto' => $docto,
            'chart' => urlencode($chart),
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();

//        return view('print.document');
    }
}
