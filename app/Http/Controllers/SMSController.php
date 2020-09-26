<?php

namespace App\Http\Controllers;

use AWS;
use App\Clients;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function sendSMS($id){

        $client = Clients::find($id);
        $phone_number = $client->country_code.$client->phone;

        $sms = AWS::createClient('sns');

        $sms->publish([
            'Message' => 'Estimado cliente, se acaba de dar de alta a nuestro servicio de alertas EFIGAS. Gracias por su preferencia.',
            'PhoneNumber' => $phone_number,
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType'  => [
                    'DataType'    => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],
        ]);

        return redirect()->route('clients.index');
    }
}
