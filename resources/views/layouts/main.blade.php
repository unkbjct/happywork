<?
    $navList = App\Models\Category::whereNull("depth")->get();
    foreach ($navList as $nav) {
        $nav->children = App\Models\Category::where("parent_id", $nav->id)->get();
    }
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">
    @yield('styles')
    <script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('public/js/main.js') }}"></script>
    @yield('scripts')
    <title>@yield('title')</title>
</head>
<style>
    :root {
        --new-price-image: url({{ asset('public/storage/images/price.svg') }})
    }
</style>

<body>
    <div class="wrapper">
        <header class="bg-body-tertiary mb-4 sh">
            <nav class="navbar navbar-expand bg-dark py-0" data-bs-theme="dark">
                <div class="container">
                    <div class="d-flex flex-wrap semi-nav w-100">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item d-flex">
                                <a class="nav-link" href="#">Напишите нам</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">happywork@gmail.com</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav mb-2 ms-auto mb-lg-0">
                            @if (Auth::check())
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="22"
                                            height="22" fill="currentColor" class="bi bi-person-circle"
                                            viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                            <path fill-rule="evenodd"
                                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                        </svg>
                                        Привет, {{ auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if (Auth::user()->status == 'ADMIN')
                                            <li>
                                                <a class="dropdown-item" target="true" href="{{ route('admin') }}">
                                                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" fill="currentColor"
                                                        class="bi bi-ui-checks" viewBox="0 0 16 16">
                                                        <path
                                                            d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                    </svg>
                                                    <span>Панель администратора</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-person"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                                </svg>
                                                <span>Мой кабинет</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.history') }}">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-clock-history"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                    <path
                                                        d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                    <path
                                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                </svg>
                                                <span>История</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.logout') }}">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-box-arrow-left"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                                                </svg>
                                                <span>Выход</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <li class="nav-item d-flex">
                                    <a class="nav-link" href="{{ route('user.signup') }}">Регистрация</a>
                                </li>
                                <div class="nav-item">
                                    <a href="" class="nav-link disabled">или</a>
                                </div>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.login') }}">Вход</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="mobile-semi-nav mb-3 w-100" style="display: none">
                        <div class="btn-group border-1 w-100">
                            <div class="dropdown w-100">
                                <button class="btn btn-dark" data-bs-toggle="dropdown">Меню</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('about') }}">О компании</a></li>
                                    <li><a class="dropdown-item" href="{{ route('repair') }}">Ремонт</a></li>
                                    {{-- <li><a class="dropdown-item" href="#">Акции</a></li> --}}
                                    <li><a class="dropdown-item" href="{{ route('tradein') }}">Рассрочка Trade-In</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('contacts') }}">Контакты</a></li>
                                </ul>
                            </div>
                            <div class="dropdown w-100">
                                <button class="btn btn-dark" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                        <path
                                            d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                    <li>
                                        <a class="dropdown-item text-center" href="#">
                                            <small>+7(921)020-98-88</small>
                                            <br>
                                            <small class="text-muted">
                                                ТД "РусьПН-ВС 10:00-21:00,
                                                <br>
                                                ТЦ "МАРМЕЛАД" Пн-Вс 10:00-21:00
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown w-100">
                                <button class="btn btn-dark" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    </svg>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-md-start">
                                    @if (Auth::check())
                                        @if (Auth::user()->status == 'ADMIN')
                                            <li>
                                                <a class="dropdown-item" target="true" href="{{ route('admin') }}">
                                                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" fill="currentColor"
                                                        class="bi bi-ui-checks" viewBox="0 0 16 16">
                                                        <path
                                                            d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                    </svg>
                                                    <span>Панель администратора</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-person"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                                </svg>
                                                <span>Мой кабинет</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-clock-history"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                    <path
                                                        d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                    <path
                                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                </svg>
                                                <span>История</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.logout') }}">
                                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" fill="currentColor" class="bi bi-box-arrow-left"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                                                </svg>
                                                <span>Выход</span>
                                            </a>
                                        </li>
                                    @else
                                        <li><a class="dropdown-item"
                                                href="{{ route('user.signup') }}">Регистрация</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user.login') }}">Авторизация</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-expand-xl bg-white">
                <div class="container">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img src="{{ asset('public/storage/images/logo.png') }}"
                            class="d-inline-block align-text-top mw-100 me-3" width="200">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0 w-100">
                            <div class="row w-100">
                                <div class="col-xl-4 munu-col">
                                    <form action="{{ route('catalog.search') }}"
                                        class="d-flex h-100 d-flex flex-column align-items-center" role="search">
                                        <div class="input-group my-auto">
                                            <input class="form-control border-end-0 border-warning" required
                                                type="search" placeholder="Поиск по магазину..." name="q">
                                            <button class="btn btn-outline-warning border-start-0 border-warning"
                                                type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#212529" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-5 munu-col">
                                    <div class="h-100 d-flex flex-column">
                                        <div class="my-auto">
                                            <a href=""
                                                class="text-decoration-none fw-semibold text-dark">+7(921)020-98-88</a>
                                            <div>
                                                <small class="text-muted">ТД "Русь ПН-ВС 10:00-21:00, ТЦ "МАРМЕЛАД"
                                                    <br>
                                                    Пн-Вс 10:00-21:00
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 munu-col">
                                    <ul class="navbar-nav w-100 mb-2 mb-lg-0 justify-content-end">
                                        <li class="nav-item" style="width: fit-content">
                                            <a href="{{ route('user.favorite') }}" class="nav-link">
                                                <div class="item-menu position-relative">
                                                    <div class="d-flex justify-content-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                            height="30" fill="#212529" class="bi bi-heart-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                        </svg>
                                                    </div>
                                                    <span id="favorites-badge"
                                                        class="@if (!Auth::check() || !Cookie::has('favorites') || sizeof(json_decode(Cookie::get('favorites'))) === 0) visually-hidden @endif position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                                                        @if (Cookie::has('favorites'))
                                                            {{ sizeof(json_decode(Cookie::get('favorites'))) }}
                                                        @endif
                                                    </span>
                                                    <span style="font-size: 14px;">Избранное</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" style="width: fit-content">
                                            <a href="{{ route('user.cart') }}" class="nav-link">
                                                <div class="item-menu position-relative">
                                                    <div class="d-flex justify-content-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                            height="30" fill="#212529" class="bi bi-cart3"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                                        </svg>
                                                    </div>

                                                    <span id="cart-badge"
                                                        class="@if (!Cookie::has('cartCount')) visually-hidden @endif position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning">
                                                        @if (Cookie::has('cartCount'))
                                                            {{ json_decode(Cookie::get('cartCount')) }}
                                                        @endif
                                                    </span>

                                                    <span style="font-size: 14px;">Корзина</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-expand-xl bg-secondary-subtle py-0" aria-expanded="false">
                <div class="container">
                    <div class="d-flex flex-nowrap w-100">
                        <div class="catalog-btn" id="catalog-btn-mobile" data-bs-toggle="offcanvas"
                            href="#mobile-catalog">
                            <a class="nav-link text-white" aria-current="page" href="#">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="white" class="bi bi-list" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <span>Каталог товаров</span>
                            </a>
                        </div>
                        <div class="catalog">
                            <div class="catalog-btn" id="catalog-btn">
                                <a class="nav-link text-white" aria-current="page" href="#">
                                    <span class="me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="white" class="bi bi-list" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                    </span>
                                    <span>Каталог товаров</span>
                                </a>
                            </div>
                            <div class="catalog-parent-list" id="catalog-parent-list">
                                @foreach ($navList as $nav)
                                    <div class="nav-children-content">
                                        <a href="{{ route('catalog.search', ['title_eng' => $nav->title_eng]) }}"
                                            type="button" class="btn btn-warning catalog-parent-btn">
                                            <span>{{ $nav->title }}</span>
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    fill="white" class="bi bi-caret-right-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                                </svg>
                                            </span>
                                        </a>
                                        <ul class="children-list p-4 d-flex flex-wrap border-end bordeb-bottom">
                                            @foreach ($nav->children as $child)
                                                <li class="child">
                                                    <a
                                                        href="{{ route('catalog.search', ['title_eng' => $child->title_eng]) }}">
                                                        <div class="child-btn">{{ $child->title }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-100">
                            <ul class="nav nav-fill main-nav bg-white">
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'about') active @endif "
                                        href="{{ route('about') }}">О компании</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'repair') active @endif"
                                        href="{{ route('repair') }}">Ремонт</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link">Акции</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'tradein') active @endif"
                                        href="{{ route('tradein') }}">Рассрочка и Trade-In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'contacts') active @endif"
                                        href="{{ route('contacts') }}">Контакты</a>
                                </li>
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link @if (str_contains(Route::currentRouteName(), 'user')) active @endif"
                                            href="{{ route('user.profile') }}">Мой кабинет</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('user.logout') }}">Выход</a>
                                    </li>
                                @endauth

                            </ul>
                            <div class="catalog-children-list">

                            </div>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
        <main id="main">
            @yield('main')


            @yield('modals')

            <div class="modal fade" id="cart-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 align-items-start">
                            <h6 id="cart-modal-text" class="text-center">
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5 pt-0 d-flex justify-content-center">
                            <img class="w-50" id="cart-modal-image" src="">
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            <button type="button" class="btn btn-sm btn-outline-dark me-2"
                                data-bs-dismiss="modal">Продолжить покупки</button>
                            <a href="{{ route('user.cart') }}" type="button" class="btn btn-sm btn-dark">В
                                корзину</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- 
        <div class="custom-alert">
            <div class="alert-text">Товар «Macbook Air 13 M2 8/256Gb Silver» успешно удалён из списка сравнения</div>
            <div class="alert-progress"></div>
        </div> --}}

        <div class="background"></div>

        <div class="offcanvas offcanvas-start bg-dark" data-bs-theme="dark" id="mobile-catalog">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Каталог</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body bg-warning p-0">
                @foreach ($navList as $nav)
                    <div class="nav-children-content">
                        <a href="{{ route('catalog.search', ['title_eng' => $nav->title_eng]) }}" type="button"
                            class="btn btn-warning catalog-parent-btn">
                            <span>{{ $nav->title }}</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white"
                                    class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                    <path
                                        d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <footer class="bg-dark mt-5 text-white" data-bs-theme="dark">
            <div class="container">
                <div class="pt-5">
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3">
                            <h5 class="mb-4">Контакты</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-3">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" fill="currentColor" class="bi bi-geo"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                                            </svg>
                                            <small class="fw-semibold">Адрес</small>
                                        </div>
                                        <small class="text-muted">Россия, Великий Новгород, ул. Большая
                                            Санкт-Петербургская, 25. ТД
                                            "Русь"</small>
                                    </div>
                                </li>
                                <li class="nav-item mb-3">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" fill="currentColor" class="bi bi-clock"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                <path
                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                            </svg>
                                            <small class="fw-semibold">Режим работы</small>
                                        </div>
                                        <small class="text-muted">ТД "Русь ПН-ВС 10:00-21:00, ТЦ "МАРМЕЛАД" Пн-Вс
                                            10:00-21:00</small>
                                    </div>
                                </li>
                                <li class="nav-item mb-3">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" fill="currentColor" class="bi bi-telephone"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                            </svg>
                                            <small class="fw-semibold">Телефон</small>
                                        </div>
                                        <small class="text-muted">+7(921)020-98-88</small>
                                    </div>
                                </li>
                                <li class="nav-item mb-3">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" fill="currentColor" class="bi bi-envelope"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                            </svg>
                                            <small class="fw-semibold">Email</small>
                                        </div>
                                        <small class="text-muted">happywork@gmail.com</small>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <h5 class="text-white">Меню</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="{{ route('home') }}"
                                        class="nav-link p-0 text-muted">Главная</a></li>
                                <li class="nav-item mb-2"><a href="{{ route('user.cart') }}"
                                        class="nav-link p-0 text-muted">Корзина</a></li>
                                <li class="nav-item mb-2"><a href="{{ route('catalog') }}"
                                        class="nav-link p-0 text-muted">Каталог</a></li>
                                <li class="nav-item mb-2"><a href="{{ route('about') }}"
                                        class="nav-link p-0 text-muted">О компании</a></li>
                                <li class="nav-item mb-2"><a href="{{ route('tradein') }}"
                                        class="nav-link p-0 text-muted">Рассрочка и Trade-In</a></li>
                                <li class="nav-item mb-2"><a href="{{ route('contacts') }}"
                                        class="nav-link p-0 text-muted">Контакты</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <h5 class="text-white">Мой кабинет</h5>
                            @if (Auth::user())
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2"><a href="{{ route('user.profile') }}"
                                            class="nav-link p-0 text-body-secondary">Мой кабинет</a></li>
                                    <li class="nav-item mb-2"><a href="{{ route('user.history') }}"
                                            class="nav-link p-0 text-body-secondary">Историзя заказов</a></li>
                                    <li class="nav-item mb-2"><a href="{{ route('user.favorite') }}"
                                            class="nav-link p-0 text-body-secondary">Избранное</a></li>
                                    <li class="nav-item mb-2"><a href="{{ route('user.logout') }}"
                                            class="nav-link p-0 text-body-secondary">Выход</a></li>
                                </ul>
                            @else
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2"><a href="{{ route('user.login') }}"
                                            class="nav-link p-0 text-body-secondary">Вход</a></li>
                                    <li class="nav-item mb-2"><a href="{{ route('user.signup') }}"
                                            class="nav-link p-0 text-body-secondary">Регистрация</a></li>
                                </ul>
                            @endif
                        </div>

                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between pt-4 mt-4 border-top">
                        <small class="text-muted">HappyWorks © 2023. Все права защищены. ИП Егорова Алена Андреевна.</small>
                        <ul class="list-unstyled d-flex">
                            <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#twitter"></use>
                                    </svg></a></li>
                            <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#instagram"></use>
                                    </svg></a></li>
                            <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#facebook"></use>
                                    </svg></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @yield('script-code')

</body>

</html>
