<?php

namespace App\Controllers;

class MainController extends Controller
{
    public function index()
    {
        return $this->view('index');
    }

    public function buyTickets()
    {
        return $this->view('buy-tickets');
    }
}