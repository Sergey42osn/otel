@if($lang == "en")
    <p>Thank you for your reservation № {{$object_id}}</p>
    <br>
    <p>You've chosen: {{$object_name}}</p>
    <p>Room type: {{$object_type}}</p>
    <p>Arrival date: {{$check_in}}</p>
    <p>Departure date: {{$check_out}}</p>
    <p>Guest Name: {{$guests}}</p>
    <br>
    <p>Total room price: {{$price}} rub.</p>
    <br>
    <p>The payment status and details of your reservation can be checked in your Personal Account on the website ruking.ru, in the section “Booking History” .</p>
    <p>If you need any help with your reservation, you can always contact us by e-mail: contact@ruking.ru or by phone: 8 800 101 11 80 and +7 499 499 88 85. You can also contact the accommodation directly.</p>
    <br>
    <p>Your faithfully,<br> Ruking.ru</p>
@else
    <p>Спасибо за Ваше бронирование № {{$object_id}}</p>
    <br>
    <p>Вы выбрали: {{$object_name}}</p>
    <p>Категория номера: {{$object_type}}</p>
    <p>Заезд: {{$check_in}}</p>
    <p>Выезд: {{$check_out}}</p>
    <p>Гость: {{$guests}}</p>
    <br>
    <p>Полная стоимость бронирования составляет: {{$price}} рублей</p>
    <br>
    <p>Проверить статус оплаты и детали Вашего бронирования мы можете в Личном кабинете на сайте ruking.ru в разделе «История бронирования».</p>
    <p> Если Вам необходима помощь с Вашим бронированием, Вы всегда можете связаться с нами по электронной почте contact@ruking.ru или по телефонам: 8 800 101 11 80 и +7 499 499 88 85, или обратиться в объект размещения напрямую.</p>
    <br>
    <p>Ваш ruking.ru</p>
@endif








