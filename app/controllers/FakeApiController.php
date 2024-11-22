<?php

namespace App\Controllers;

class FakeApiController extends Controller
{
    public function approve()
    {
        $messages = [
            ['message' => 'order successfully approved'],
            [
                ['error' => 'event cancelled'],
                ['error' => 'no tickets'],
                ['error' => 'no seats'],
                ['error' => 'fan removed'],
            ]
        ];

        $randArrIndex = mt_rand(0, count($messages) - 1);
        $randMessIndex = mt_rand(0, count($messages[$randArrIndex]) - 1);

        $data = $randArrIndex === 0
                ? json_encode($messages[$randMessIndex])
                : json_encode($messages[$randArrIndex][$randMessIndex]);

        return $data;
    }

    public function book()
    {
        $messages = [
            ['message' => 'order successfully booked'],
            ['error' => 'barcode already exists']
        ];

        return json_encode($messages[mt_rand(0, count($messages) - 1)]);
    }
}