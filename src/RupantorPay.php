<?php

namespace RupantorPay;

use Exception;

class RupantorPay
{
    protected $apiUrl = 'https://payment.rupantorpay.com/api';
    protected $apiKey;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?? config('services.rupantorpay.api_key');
    }

    public function createPayment(array $data)
    {
        return $this->request('/payment/checkout', $data);
    }

    public function verifyPayment($transactionId)
    {
        return $this->request('/payment/verify-payment', [
            'transaction_id' => $transactionId
        ]);
    }

    protected function request($endpoint, $payload)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "X-API-KEY: {$this->apiKey}",
                "Content-Type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) throw new Exception("cURL Error: " . $err);

        return json_decode($response, true);
    }
}
