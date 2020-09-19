<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use AWS;

class SMSController extends Controller
{
    protected function sendSMS($id){

        $client = Clients::find($id);
        $phone_number = $client->country_code.$client->phone;

        $sms = AWS::createClient('sns');

        $sms->publish([
            'Message' => 'Estimado cliente, esta recibiendo este mensaje porque presenta un adeudo en su cuenta, o lo paga o se lo carga el payaso.',
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
