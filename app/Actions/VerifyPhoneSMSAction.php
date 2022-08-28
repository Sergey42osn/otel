<?php

namespace App\Actions;

class VerifyPhoneSMSAction
{
    public function execute($telephone, $code, $originator)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://45.131.124.7/broker-api/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "messages":{
                "recipient":' . $telephone . ',
                "priority":2,
                "sms":{
                    "originator":' . $originator . ',
                    "content":{
                        "text":' . $code . '
                        }
                },
                "message-id":' . time() . '
            }
        }');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, env('BROKER_SMS_API_USERNAME') . ':' . env('BROKER_SMS_API_PASSWORD'));

        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
