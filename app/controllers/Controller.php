<?php

namespace App\Controllers;

class Controller
{
    protected function view(string $view)
    {
        require_once 'static/views/' . $view . '.php';
    }
}