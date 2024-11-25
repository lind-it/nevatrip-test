<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="static/css/index.css">
</head>
<body>
    <div class="banner">
        <form action="/create-order" method="POST">
            <input type="hidden" name="event_id" value="001">
            <div class="header">
                <h2>Король и шут</h2>
                <div class="price">
                    <div>Цена билета для взрослых: <input class="unchanged" name="price[adult]" type="text" value="100" readonly></div>
                    <div>Цена билета для детей: <input class="unchanged" name="price[kid]" type="text" value="50" readonly></div>
                </div>
            </div>

            <div class="form">
                <div>
                    <label for="">Введите количество взрослых билетов</label>
                    <input name="quantity[adult]" type="number">
                </div>
                <div>
                    <label for="">Введите количество детских билетов</label>
                    <input name="quantity[kid]" type="number">
                </div>
            </div>

            <div class="buy">
                <div>Дата: <input class="unchanged" name="event_date" type="text" value="21.10.2012" readonly></div>
                <input class="buy-button" type="submit" value="Купить">
            </div>

        </form>
    </div>

    <div class="banner">
        <form action="/create-order" method="POST">
            <input type="hidden" name="event_id" value="002">
            <div class="header">
                <h2>Театр Драммы</h2>
                <div class="price">
                    <div>Цена билета для взрослых: <input class="unchanged" name="price[adult]" type="text" value="800" readonly></div>
                    <div>Цена билета для детей: <input class="unchanged" name="price[kid]" type="text" value="400" readonly></div>
                    <div>Цена льготного билета: <input class="unchanged" name="price[preferential]" type="text" value="400" readonly></div>
                </div>
            </div>

            <div class="form">
                <div>
                    <label for="">Введите количество взрослых билетов</label>
                    <input name="quantity[adult]" type="number">
                </div>
                <div>
                    <label for="">Введите количество детских билетов</label>
                    <input name="quantity[kid]" type="number">
                </div>
                <div>
                    <label for="">Введите количество льготных билетов</label>
                    <input name="quantity[preferential]" type="number">
                </div>
            </div>

            <div class="buy">
                <div>Дата: <input class="unchanged" name="event_date" type="text" value="14.01.2013" readonly></div>
                <input class="buy-button" type="submit" value="Купить">
            </div>

        </form>
    </div>

</body>
</html>