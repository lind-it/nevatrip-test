<?php

namespace App\Controllers;

use App\Models\Ticket;

class TiccketController extends Controller
{
    public function createOrder()
    {
        $connection = new \PDO("mysql:host=localhost;dbname=nevatrip", "root", "");

        // передаем соединение для модели
        Ticket::setConnect($connection);

        // запрос на создание строки в таблице
        $query =
            '
            INSERT INTO `tickets`
                    (`event_id`, 
                     `event_date`, 
                     `ticket_adult_price`,
                     `ticket_adult_quantity`, 
                     `ticket_kid_price`, 
                     `ticket_kid_quantity`, 
                     `barcode`, 
                     `equal_price`, 
                     `created`) 
                VALUES 
                    (:event_id, 
                     :event_date, 
                     :ticket_adult_price,
                     :ticket_adult_quantity,
                     :ticket_kid_price,
                     :ticket_kid_quantity,
                     :barcode,
                     :equal_price,
                     :created)
            ';

        // получаем данные для записи
        $event_id = $_POST['event_id'];
        $event_date = $_POST['event_date'];
        $ticket_adult_price = (int) $_POST['ticket_adult_price'];
        $ticket_adult_quantity = (int) $_POST['ticket_adult_quantity'];
        $ticket_kid_price = (int) $_POST['ticket_kid_price'];
        $ticket_kid_quantity = (int) $_POST['ticket_kid_quantity'];
        $equal_price = ($ticket_adult_price * $ticket_adult_quantity) + ($ticket_kid_price * $ticket_kid_quantity);
        $created = date("Y-m-d");

        // складываем данные для записи в один массив
        $queryData = [
            'event_id' => $event_id,
            'event_date' => $event_date,
            'ticket_adult_price' => $ticket_adult_price,
            'ticket_adult_quantity' => $ticket_adult_quantity,
            'ticket_kid_price' => $ticket_kid_price,
            'ticket_kid_quantity' => $ticket_kid_quantity,
            'barcode' => Ticket::generateBarcode(),
            'equal_price' => $equal_price,
            'created' => $created,
        ];

        $booked = Ticket::request('http://nevatrip-test/api.site.com/book', json_encode($queryData), 'json');
        $booked = json_decode($booked, true);

        while (isset($booked['error']))
        {
            $queryData['barcode'] = Ticket::generateBarcode();
            $booked = Ticket::request('http://nevatrip-test/api.site.com/book', json_encode($queryData), 'json');
        }

        $approved = Ticket::request('http://nevatrip-test/api.site.com/approve',  json_encode(['barcode' => $queryData['barcode']]), 'json');
        $approved = json_decode($approved, true);

        if (isset($approved['error']))
        {
            return json_encode($approved);
        }

        // делаем запрос
        $result = Ticket::query($query, $queryData);

        // если запрос выдал ошибку по уникальному баркоду
        while ($result['status'] === 'error' && $result['code'] === '23000')
        {
            $queryData['barcode'] = Ticket::generateBarcode();
            $result = Ticket::query($query, $queryData);
        }
        return json_encode($result);
    }
}