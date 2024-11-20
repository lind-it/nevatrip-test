<?php

namespace App\Models;

class Model
{
    static private $connect;

    static public function setConnect(PDO $connect)
    {
        self::$connect = $connect;
    }

    static public function query(string $query, array $data)
    {
        // подготавливаем запрос
        $stmt = self::$connect->prepare($query);

        //выполняем запрос
        $stmt->execute($data);

        // устанавливаем, чтобы данные передавались в свойства класса
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);

        return $stmt->fetch();
    }
}
