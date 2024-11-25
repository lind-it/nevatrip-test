<?php

namespace App\Controllers;

use App\Models\Ticket;

class TicketController extends Controller
{
    public static function createTicket($order_id, $type_name, $price)
    {
        $connection = new \PDO("mysql:host=localhost;dbname=nevatrip", "root", "");

        // передаем соединение для модели
        Ticket::setConnect($connection);

        $query =
            '
            INSERT INTO `tickets`
                    (`order_id`, 
                     `ticket_type_id`, 
                     `barcode`, 
                     `price`) 
                VALUES 
                    (:order_id, 
                     :ticket_type_id, 
                     :barcode,
                     :price)
            ';

        $ticket_type_id = TicketsTypeController::getTypeId($type_name)['data']['id'];

        if (is_null($ticket_type_id))
        {
            return false;
        }

        $queryData = [
            'order_id' => $order_id,
            'ticket_type_id' => $ticket_type_id,
            'barcode' => Ticket::generateBarcode(),
            'price' => $price
        ];

        $result = Ticket::query($query, $queryData);

        // если баркод билета уже сеществует
        while (isset($result['error']) && $result['error'] === '23000')
        {
            // меняем баркод
            $queryData['barcode'] = Ticket::generateBarcode();

            $result = Ticket::query($query, $queryData);
        }

        return json_encode($result);
    }
}