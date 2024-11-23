<?php

use App\Services\Router;
use App\Controllers\MainController;
use App\Controllers\FakeApiController;
use App\Controllers\OrderController;


// создаем маршруты для главной страницы
Router::route('GET', '/', [MainController::class, 'index']);
Router::route('GET', '/buy-tickets', [MainController::class, 'buyTickets']);

// создаем маршрут для заказа билетов
Router::route('POST', '/create-order', [OrderController::class, 'createOrder']);

// создаем маршруты фэйк-апи
Router::route('POST', '/api.site.com/approve', [FakeApiController::class, 'approve']);
Router::route('POST', '/api.site.com/book', [FakeApiController::class, 'book']);

Router::enable();