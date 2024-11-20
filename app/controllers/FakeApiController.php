<?php

namespace App\Controllers;

class FakeApiController extends Controller
{
    public function success()
    {
        return json_encode(['message' => 'order successfully booked']);
    }

    public function fail()
    {
        $fails = [
            ['error' => 'event cancelled'],
            ['error' => 'no tickets'],
            ['error' => 'no seats'],
            ['error' => 'fan removed'],
        ];

        return json_encode($fails[rand(0, count($fails) - 1)]);
    }
}