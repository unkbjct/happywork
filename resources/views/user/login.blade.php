@extends('layouts.main')

@section('title')
    Вход в личный кабинет
@endsection

@section('script-code')
    <script>
        $("#btn-submit").click(() => {
            $.ajax({
                url: '{{ route('api.user.login') }}',
                method: 'POST',
                data: {
                    email: $("#email").val(),
                    passwd: $("#passwd").val(),
                },
                success: function(e) {
                    // console.log(e)
                    window.location = e.data.url
                },
                error: function(e) {
                    console.log(e)
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })
    </script>
@endsection

@section('main')
    <div class="container">
        <section class="mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('home') }}">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Вход в личный кабинет</li>
                </ol>
            </nav>
        </section>
        <section class="border mb-5">
            <div class="p-4 border-bottom">
                <h1 class="h2">Вход в личный кабинет</h1>
            </div>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="border-end p-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Электронная почта *</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="passwd" class="form-label">Пароль *</label>
                            <input type="password" class="form-control" id="passwd">
                        </div>
                        <button type="submit" class="btn btn-dark mb-2" id="btn-submit">Войти</button>
                        <button class="btn btn-dark mb-2">Забыли пароль</button>
                        <p>* Обязательные поля</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-3">
                        <div class="h3">Зарегистрировать аккаунт</div>
                        <p>Зарегистрировавшись в нашем магазине, Вы сможете оформлять заказы быстрее, просматривать и
                            отслеживать Ваши заказы, хранить адреса доставки и многое другое.</p>
                        <div>
                            <a href="{{route('user.signup')}}" class="btn btn-dark mb-2">Зарегистрироваться</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
