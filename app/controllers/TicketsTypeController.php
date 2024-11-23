<?php

namespace App\controllers;

use App\Models\TicketsType;

class TicketsTypeController extends Controller
{
    public static function getTypeId(string $ticketTypeName)
    {
        $connection = new \PDO("mysql:host=localhost;dbname=nevatrip", "root", "");

        // передаем соединение для модели
        TicketsType::setConnect($connection);

        $query = '
            SELECT `id` 
            FROM `tickets_types`
            WHERE `type_name` = :type_name;
        ';

        $queryData = [':type_name' => $ticketTypeName];

        $result = TicketsType::query($query, $queryData);

        if(isset($result['error']) || !$result)
        {
            return null;
        }

        return $result;

    }
}