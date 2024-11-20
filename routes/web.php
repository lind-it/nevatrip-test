<?php

use App\Services\Router;
use App\Controllers\MainController;
use App\Controllers\FakeApiController;
use App\Controllers\TiccketController;


// создаем маршрут для главной страницы
Router::route('GET', '/', [MainController::class, 'index']);

// создаем маршрут для заказа билетов
Router::route('GET', '/api', [TiccketController::class, 'createOrder']);

// создаем маршруты фэйк-апи
Router::route('GET', '/api.site.com/approve/success', [FakeApiController::class, 'success']);
Router::route('GET', '/api.site.com/approve/fail', [FakeApiController::class, 'fail']);



Router::enable();