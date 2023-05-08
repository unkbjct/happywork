@extends('layouts.main')

@section('title')
    О компании
@endsection

@section('main')
    <div class="container">
        <section class="mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item">О компании</li>
                </ol>
            </nav>
        </section>
        <section>
            <div class="card card-body">
                <h1 class="h3 mb-4">О компании</h1>
                <p>Happy Works - дружелюбный магазин техники Apple, Samsung, Xiaomi по лучшим ценам, а так же ремонта</p>
                <p>С 1 марта 2017 года работаем для вас</p>
                <div class="mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Выкуп смартфонов</li>
                        <li class="list-group-item">Кредит/Рассрочка на все</li>
                        <li class="list-group-item">Бесплатная доставка по городу</li>
                        <li class="list-group-item">Только Оригинальная техника</li>
                        <li class="list-group-item">Самовывоз (ТД Русь и ТЦ Мармелад)</li>
                        <li class="list-group-item">Trade-in (Обмен старого телефона на новый)</li>
                    </ul>
                </div>
                <p>Нашли дешевле? Снизим цену!</p>
                <p>Телефон: 8 921 020 98 88</p>
                <p>Наш адрес: <br> Большая Санкт-Петербургская, д.25 <br> ТД "Русь" Ломоносова, д.29 ТРЦ "Мармелад" 1 этаж
                </p>
            </div>
        </section>
    </div>
@endsection
