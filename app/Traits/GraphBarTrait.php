<?php


namespace App\Traits;


trait GraphBarTrait
{
    public function generateChart($historic)
    {
        // Se arma el array para el histórico
        $arr_period = '[';
        $arr_data = '[';
        foreach ($historic->take(13) as $h)
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

        return $chart;
    }
}
