<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPUnit\Exception;

class LifePayService
{
    protected $payment_url = 'https://partner.life-pay.ru/alba/input';

    public function process($order)
    {
        $order->update([
            'order_id' => strtotime("now")
        ]);
        $key = env('LIFEPAY_KEY');
        $request_data = array(
            'key' => $key,
            'cost' => $order->price,
            'name' => $order->name,
            'default_email' => $order->email,
            'order_id' => $order->order_id
        );
        $http_query_params = http_build_query($request_data);
        try {
            redirect()->to($this->payment_url.'?'.$http_query_params)->send();
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
