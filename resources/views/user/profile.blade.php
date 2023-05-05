@extends('layouts.user')

@section('title')
    Мой кабинет
@endsection

@section('script-code')
    <script>
        let isShowenPasswd = false;
        let personalHaveEmpty = false;
        $("#visibility-passwd").click(function() {
            $("#passwd").attr("type", isShowenPasswd ? 'password' : 'text');
            $($(this).children()[0]).toggleClass("visually-hidden");
            $($(this).children()[1]).toggleClass("visually-hidden");
            isShowenPasswd = !isShowenPasswd;
        })

        $(".input-personal").on("input", function() {
            let isChanged = false;
            $(".input-personal").each((index, element) => {
                if ($(element).val() && $(element).val() != $(element).data("old-value")) isChanged = true;
                if (!$(element).val()) personalHaveEmpty = true;
            });
            (isChanged && !personalHaveEmpty) ?
            $("#btn-submit-personal").removeClass("disabled"): $("#btn-submit-personal").addClass("disabled");
            personalHaveEmpty = false;
        })

        $("#btn-submit-personal").click(function() {
            $.ajax({
                url: '{{ route('api.user.edit.personal') }}',
                method: 'POST',
                data: {
                    api_token: $("#api_token").val(),
                    name: $("#name").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    passwd: $("#passwd").val(),
                },
                success: function(e) {
                    console.log(e)
                    // window.location = e.data.url;
                    showAlert([e.message], 'alert-success')
                    $("#btn-submit-personal").addClass("disabled");
                },
                error: function(e) {
                    console.log(e)
                    if (e.status == 403) return;
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })

        $("#btn-submit-address").click(function() {
            $.ajax({
                url: '{{ route('api.user.edit.address') }}',
                method: 'POST',
                data: {
                    api_token: $("#api_token").val(),
                    area: $("#area").val(),
                    city: $("#city").val(),
                    address_index: $("#address_index").val(),
                    address: $("#address").val(),
                },
                success: function(e) {
                    console.log(e)
                    showAlert([e.message], 'alert-success')
                    $("#btn-submit-personal").addClass("disabled");
                },
                error: function(e) {
                    console.log(e)
                    if (e.status == 403) return;
                    showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })
    </script>
@endsection

@section('user')
    <div class="">
        <div class="p-3">
            <h1 class="h3">Личный кабинет</h1>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="p-3">
                    <h4 class="border-bottom">Персональный данные</h4>
                    <div class="pe-5">
                        <input type="hidden" name="api_token" id="api_token" value="{{ Auth::user()->api_token }}">
                        <div class="mb-2">
                            <label for="name" class="form-label">Ваше имя * </label>
                            <input value="{{ Auth::user()->name }}" data-old-value="{{ Auth::user()->name }}" type="text"
                                class="form-control input-personal" id="name">
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Почта для связи *</label>
                            <input value="{{ Auth::user()->email }}" data-old-value="{{ Auth::user()->email }}"
                                type="email" class="form-control input-personal" id="email">
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="form-label">Телефон для связи *</label>
                            <input value="{{ Auth::user()->phone }}" data-old-value="{{ Auth::user()->phone }}"
                                type="text" class="form-control input-personal" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="passwd" class="form-label">Пароль *</label>
                            <div class="input-group">
                                <input value="{{ Auth::user()->passwd }}" data-old-value="{{ Auth::user()->passwd }}"
                                    type="password" class="form-control input-personal border-end-0" id="passwd">
                                <button class="btn btn-light" id="visibility-passwd">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                    <svg class="visually-hidden" xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                        <path
                                            d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
                                        <path
                                            d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
                                        <path
                                            d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="btn-submit-personal"
                            class="btn btn-dark mb-2 disabled">Сохранить</button>
                        <p>* Обязательные поля</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-3">
                    <h4 class="border-bottom">Адрес доставки</h4>
                    <div class="pe-5">
                        <div class="mb-2">
                            <label for="area" class="form-label">Область</label>
                            <input value="{{ Auth::user()->area }}" type="text" class="form-control" id="area">
                        </div>
                        <div class="mb-2">
                            <label for="city" class="form-label">Город</label>
                            <input value="{{ Auth::user()->city }}" type="text" class="form-control" id="city">
                        </div>
                        <div class="mb-2">
                            <label for="address_index" class="form-label">Почтовый индекс</label>
                            <input value="{{ Auth::user()->address_index }}" type="number" class="form-control"
                                id="address_index">
                        </div>
                        <div class="mb-2">
                            <label for="address" class="form-label">Адрес доставки</label>
                            <textarea name="address" id="address" rows="3" class="form-control">{{ Auth::user()->address }}</textarea>
                        </div>
                        <button type="button" id="btn-submit-address" class="btn btn-dark mb-2">Сохранить</button>
                        <p>* Обязательные поля</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
