<?php

namespace App\Services\Api;


class NewTelService
{
    protected string $apiStartCallUrl = 'https://api.new-tel.net/call-password/start-password-call';

    public function send($phone,$code)
    {


            if (strpos($phone,"+") !== false)
            {
                $phone = substr($phone,1);
            }

        $data = json_encode([
            'dstNumber' => $phone,
            'pin' => $code,
            'timeout' => 20
        ]);
        $time = time();
        $resId = curl_init();

        $key = $this->getKey('call-password/start-password-call',
            $time,'5320163d44aa0baa842f800399761272af384796acdfdf09',
            $data,'e60b8e42cc511587c456b3fcc238d4f351e6787556c0e301');
        curl_setopt_array($resId, [
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.$key ,
                'Content-Type: application/json' ,
            ],
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $this->apiStartCallUrl,
            CURLOPT_POSTFIELDS => $data,
        ]);
        $response = curl_exec($resId);
        $curlInfo = curl_getinfo($resId);

//        echo $response;
    }

    function getKey ($methodName , $time , $keyNewtel , $params , $writeKey
    )
    {
        return $keyNewtel.$time.hash( 'sha256' ,
                $methodName."\n".$time."\n".$keyNewtel."\n".
                $params."\n".$writeKey);
    }

}
