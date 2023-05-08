@extends('layouts.main')

@section('title')
    Контакты
@endsection

@section('main')
    <div class="container">
        <section class="mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item">Контакты</li>
                </ol>
            </nav>
        </section>
        <section>
            <div class="card card-body">
                <h1 class="h3 mb-4">Контакты</h1>
                <h4 class="mb-0">Наши контакты</h4>
                <hr class="mb-4">
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <svg class="me-2 p-1" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            fill="var(--bs-warning)" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                        </svg>
                        <span>Россия, Великий Новгород, ул. Большая Санкт-Петербургская, 25. ТД "Русь"</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <svg class="me-2 p-1" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            fill="var(--bs-warning)" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                        </svg>
                        <span>Россия, Великий Новгород, ул. Ломоносова, 29. ТЦ "МАРМЕЛАД"</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <svg class="me-2 p-1" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            fill="var(--bs-warning)" class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        </svg>
                        <span>ТД "Русь ПН-ВС 10:00-21:00, ТЦ "МАРМЕЛАД" Пн-Вс 10:00-21:00</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <svg class="me-2 p-1" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            fill="var(--bs-warning)" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                        </svg>
                        <span>+7(921)020-98-88</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <svg class="me-2 p-1" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="var(--bs-warning)"
                            class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                        </svg>
                        <span>happywork@yandex.ru</span>
                    </div>
                </div>
                <iframe
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3A675017bcacd4d3fc5a1adc66d105385e6cd8fda155ab9225ee1f9ebaf6f124e1&amp;source=constructor"
                    width="100%" height="400" frameborder="0"></iframe>
            </div>
        </section>
    </div>
@endsection
