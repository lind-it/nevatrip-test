<?php

namespace App\Models;

class Order extends Model
{

    public static function generateBarcode()
    {
        $barcodeLength = mt_rand(5, 10);

        while ($barcodeLength > 0) {
            $barcode .= mt_rand(0, 9);
            $barcodeLength--;
        }

        return $barcode;
    }

    public static function request(string $url, $data, $type)
    {
        $requestType = [
            'json' => ['Content-Type' => 'application/json'],
            'form-data' => ['Content-Type' => 'multipart/form-data'],
        ];

        // Определение параметров сеанса
        $curlOptions = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => $requestType[$type],
            CURLOPT_POSTFIELDS => $data
        );

        // Инициализация сеанса
        $ch = curl_init();

        // установка параметров сеанса
        curl_setopt_array($ch, $curlOptions);

        // отправка запроса на подтверждение заказа
        $data = curl_exec($ch);

        return $data;
    }

}