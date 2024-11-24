<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function createOrder()
    {
        $connection = new \PDO("mysql:host=localhost;dbname=nevatrip", "root", "");

        // передаем соединение для модели
        Order::setConnect($connection);

        // запрос на создание строки в таблице
        $query =
            '
            INSERT INTO `orders`
                    (`event_id`, 
                     `event_date`,
                     `equal_price`, 
                     `barcode`, 
                     `created`) 
                VALUES 
                    (:event_id, 
                     :event_date, 
                     :equal_price,
                     :barcode,
                     :created)
            ';

        // получаем данные для записи
        $event_id = $_POST['event_id'];
        $event_date = $_POST['event_date'];
        $created = date("Y-m-d");
        $barcode = Order::generateBarcode();

        // получаем количества разных типов билетов
        foreach ($_POST['quantity'] as $key => $value)
        {
            $quantityValues[] = $value;
        }

        // получаем цены разных типов билетов
        foreach ($_POST['price'] as $key => $value)
        {
            $priceValue[] = $value;
        }

        //получаем итоговую цену заказа
        for ($i = 0; $i < count($quantityValues); $i++)
        {
            $equal_price += (int) $priceValue[$i] * (int) $quantityValues[$i];
        }

        // складываем данные для записи в один массив
        $queryData = [
            'event_id' => $event_id,
            'event_date' => $event_date,
            'equal_price' => $equal_price,
            'barcode' => $barcode,
            'created' => $created,
        ];

        // функция, которая проверяет успешность брони
        $booked = function () use ($queryData) {
            $booked = Order::request('http://nevatrip-test/api.site.com/book', json_encode($queryData), 'json');
            $booked = json_decode($booked, true);

            while (isset($booked['error'])) {

                $booked = Order::request('http://nevatrip-test/api.site.com/book', json_encode($queryData), 'json');
            }

            return true;
        };

        // функция, которая проверяет возможность купить билеты
        $approved = function () use ($queryData)
        {
            $approved = Order::request('http://nevatrip-test/api.site.com/approve',  json_encode(['barcode' => $queryData['barcode']]), 'json');
            $approved = json_decode($approved, true);

            return json_encode($approved);
        };

        // подтверждаем успешность брони
        if ($booked())
        {
            $isApproved = $approved();

            // подтверждаем оформленный заказ
            if (isset($isApproved['error']))
            {
                return json_encode($isApproved);
            }
        }

        // делаем запрос
        $result = Order::query($query, $queryData);

        // если баркод заказа уже сеществует
        while (isset($result['error']) && $result['error'] === '23000')
        {
            // меняем баркод
            $queryData['barcode'] = Order::generateBarcode();

            // подтверждаем успешность брони
            if ($booked())
            {
                $isApproved = $approved();

                // подтверждаем оформленный заказ
                if (isset($isApproved['error']))
                {
                    return json_encode($isApproved);
                }
            }

            $result = Order::query($query, $queryData);
        }

        // получаем id заказа
        $order_id = Order::query('
                    SELECT `id` FROM Orders WHERE `barcode` = :barcode',
                    [
                        'barcode' => $queryData['barcode']
                    ])['data']['id'];

        foreach ($_POST['quantity'] as $key => $value)
        {
            for($i = 1; $i <= $value; $i++)
            {
                TicketController::createTicket($order_id, $key, $_POST['price'][$key]);
            }
        }

        return json_encode($_POST['quantity']);
    }
}