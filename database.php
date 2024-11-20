<?php

use App\Models\Model;

// подключаемся к базе данных
$connection = new PDO("mysql:host=localhost;dbname=nevatrip", "root", "");

// передаем соединение для всех моделей
Model::setConnect($connection);