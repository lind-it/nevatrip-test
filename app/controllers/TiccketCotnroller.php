<?php

namespace App\Controllers;

use App\Models\Ticket;

class TiccketController extends Controller
{
    public function createOrder()
    {
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

        Ticket::query($query, []);
    }
}