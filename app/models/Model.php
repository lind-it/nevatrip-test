<?php

namespace App\Models;

class Model
{
    static private $connect;

    static public function setConnect(\PDO $connect)
    {
        self::$connect = $connect;
    }

    static public function query(string $query, array $data)
    {
        // подготавливаем запрос
        $stmt = self::$connect->prepare($query);

        //выполняем запрос
        $stmt->execute($data);

        if($stmt->errorCode() !== '00000')
        {
            return [
                    'status' => 'error',
                    'code' => $stmt->errorCode()
            ];
        }

        return ['status' => 'ok'];
    }
}
