@extends('layouts.main')

@section('title')
    Создание аккаунта
@endsection


@section('script-code')
    <script>
        $("#btn-submit").click(() => {
            // return
            $.ajax({
                url: '{{ route('api.user.create') }}',
                method: 'POST',
                data: {
                    name: $("#name").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    passwd: $("#passwd").val(),
                },
                success: function(e) {
                    console.log(e)
                    window.location = e.data.url;
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
                    <li class="breadcrumb-item active" aria-current="page">Регистрация клиента</li>
                </ol>
            </nav>
        </section>
        <section class="border">
            <div class="p-4 border-bottom">
                <h1 class="h2">Регистрация клиента</h1>
            </div>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="border-end p-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ваше имя * </label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Почта для связи *</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон для связи *</label>
                            <input type="phone" class="form-control" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="passwd" class="form-label">Придумайте пароль *</label>
                            <input type="password" class="form-control" id="passwd">
                        </div>
                        <p>Нажимая на кнопку Зарегистрироваться, Вы соглашаетесь с <a href="">правилами обработки
                                данных</a>.
                        </p>
                        <button type="button" id="btn-submit" class="btn btn-dark mb-2">Зарегистрироваться</button>
                        <p>* Обязательные поля</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-3">
                        <div class="h3">Если уже есть аккаунт</div>
                        <p>Если Вы уже имеете аккаунт у нас, пожалуйста, входите.
                            Если Вы забыли пароль, воспользуйтесь формой восстановления.</p>
                        <div>
                            <a href="{{ route('user.login') }}" class="btn btn-dark mb-2">Вход с паролем</a>
                            <button class="btn btn-dark mb-2">Восстановление пароля</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
