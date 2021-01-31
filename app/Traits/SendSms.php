<?php

namespace App\Traits;

trait SendSms
{
    public function receiptGenerated($phoneNumber)
    {
        $sms = \AWS::createClient('sns');
        return $sms->publish([
            'Message' => 'Estimado cliente, se ha generado su recibo de servicio de gas y se ha enviado a su correo electrónico registrado.',
            'PhoneNumber' => $phoneNumber,
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType'  => [
                    'DataType'    => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],
        ]);
    }
}
