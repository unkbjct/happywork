@extends('layouts.main')

@section('script-code')
    <script>
        // let amount = (Number)("{{ $amount }}");
        $(".cart-btn-count-minus").click(function() {
            if ((Number)($(this).next().val()) <= 1) return;
            $(this).next().val((Number)($(this).next().val()) - 1)
            editCartItem(this.dataset.productId, this.dataset.productCurrentPrice)
        })

        $(".cart-btn-count-plus").click(function() {
            $(this).prev().val((Number)($(this).prev().val()) + 1)
            editCartItem(this.dataset.productId, this.dataset.productCurrentPrice)
        })

        $("input.count-product").on("change", function() {
            // console.log(this.dataset.productCurrentPrice)
            editCartItem(this.dataset.productId, this.dataset.productCurrentPrice)
        })

        $(".btn-remove-cart-item").click(function() {
            $.ajax({
                url: "{{ route('api.catalog.cart.remove') }}",
                method: 'post',
                data: {
                    product: this.dataset.productId,
                },
                success: (e) => {
                    showAlert([e.message], 'alert-success')
                    localStorage.setItem("message-success", e.message)
                    location.reload();
                    // $(`#full-product-${productId}-price`).text((count * currentPrice).toLocaleString())
                },
                error: (e) => {
                    console.log(e)
                    // showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })
        })

        function editCartItem(productId, currentPrice) {
            let count = (Number)($(`#product-${productId}-input-count`).val()) ? (Number)($(
                `#product-${productId}-input-count`).val()) : 1;

            // amount -= (count * currentPrie);
            $.ajax({
                url: "{{ route('api.catalog.cart.edit') }}",
                method: 'post',
                data: {
                    product: productId,
                    count: count,
                },
                success: (e) => {
                    showAlert([e.message], 'alert-success')
                    $(`#full-product-${productId}-price`).text((count * currentPrice).toLocaleString())
                    let amount = 0;
                    $("input.count-product").each((i, e) => {
                        amount += (Number)(e.value) * (Number)(e.dataset.productCurrentPrice)
                    })
                    $("#amount-with-delivery").text(((Number)($("#delivery").val()) + amount).toLocaleString())
                    $(".amount").text((amount).toLocaleString())
                    // alert()
                },
                error: (e) => {
                    console.log(e)
                    // showAlert(e.responseJSON.data.errors, 'alert-danger')
                }
            })

        }

        $("#delivery").on("change", function() {
            $(".delivery-text").text(this.value)
            // alert($("#delivery")[0].options[$("#delivery")[0].selectedIndex].textContent)
            let amount = 0;
            $("input.count-product").each((i, e) => {
                amount += (Number)(e.value) * (Number)(e.dataset.productCurrentPrice)
            })
            $("#amount-with-delivery").text(((Number)($("#delivery").val()) + amount).toLocaleString())
        })

        $("#create-order").click(function() {
            $.ajax({
                url: "{{ route('api.catalog.order.create') }}",
                method: 'post',
                data: {
                    name: $("#name").val(),
                    phone: $("#phone").val(),
                    email: $("#email").val(),
                    city: $("#city").val(),
                    street: $("#street").val(),
                    house: $("#house").val(),
                    apart: $("#apart").val(),
                    comment: $("#comment").val(),
                    delivery: $("#delivery")[0].options[$("#delivery")[0].selectedIndex].textContent,
                    amount: (Number)($(".amount")[0].textContent.replace(" ", "")),
                    delivery_price: $("#delivery").val(),
                    user: this.dataset.user,
                },
                success: (e) => {
                    window.location = e.data.url;
                    localStorage.setItem("message-success", e.message)
                    showAlert([e.message], 'alert-success')
                },
                error: (e) => {
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
                    <li class="breadcrumb-item active" aria-current="page">Корзина</li>
                </ol>
            </nav>
        </section>
        <section class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3">
                        @if ($products->isEmpty())
                            Корзина покупок пуста
                        @else
                            Корзина
                        @endif
                    </h1>
                    <hr class="mb-4">
                    <ul class="list-group mb-4">
                        @forelse ($products as $product)
                            <li class="list-group-item p-0">
                                <div class="row g-0">
                                    <div class="col-lg-5 border-end cart-edit-border">
                                        <div class="row px-3 pb-2">
                                            <div class="col-3 col-lg-3 mx-auto">
                                                <a
                                                    href="{{ route('catalog.product', ['title_eng' => $product->title_eng]) }}">
                                                    <img class="w-100" src="{{ asset($product->image) }}" alt="">
                                                </a>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-8 d-flex align-items-center justify-content-start">
                                                <div class="fw-semibold">{{ $product->title }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-lg-2 border-end d-flex align-items-center justify-content-center">
                                        <div class="fw-semibold">
                                            <span
                                                id="product-{{ $product->id }}-price">{{ number_format($product->currentPrice, 0, 0, ' ') }}</span>
                                            ₽
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-2 border-end d-flex align-items-center justify-content-center">
                                        @if ($product->count)
                                            <div class="d-flex flex-nowrap justify-content-between">
                                                <div class="input-group me-1" style="width: 90px">
                                                    <button data-product-id="{{ $product->id }}"
                                                        data-product-current-price="{{ $product->currentPrice }}"
                                                        class="btn btn-sm btn-outline-secondary border-dark-subtle cart-btn-count cart-btn-count-minus">-</button>
                                                    <input type="number" value="{{ $product->cartCount }}"
                                                        id="product-{{ $product->id }}-input-count"
                                                        data-product-id="{{ $product->id }}"
                                                        data-product-current-price="{{ $product->currentPrice }}"
                                                        class="form-control form-control-sm border-dark-subtle text-center px-0 count-product">
                                                    <button data-product-id="{{ $product->id }}"
                                                        data-product-current-price="{{ $product->currentPrice }}"
                                                        class="btn btn-sm btn-outline-secondary border-dark-subtle cart-btn-count cart-btn-count-plus">+</button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex flex-nowrap justify-content-between">
                                                <button class="btn btn-sm btn-outline-danger w-100 disabled">
                                                    <span>Нет в наличии</span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-4 col-lg-2 border-end d-flex align-items-center justify-content-center">
                                        <div class="fw-semibold">
                                            <span
                                                id="full-product-{{ $product->id }}-price">{{ number_format($product->currentPrice * $product->cartCount, 0, 0, ' ') }}</span>
                                            ₽
                                        </div>
                                    </div>
                                    <div class="col-1 col-lg-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-link text-secondary btn-remove-cart-item"
                                            data-product-id="{{ $product->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="p-3">
                                <div class="px-3 py-2 text-white bg-warning">
                                    <div>Ваш список избранных товаров пуст. Вы можете добавлять сюда товары из <a
                                            class="text-white" href="{{ route('catalog') }}">каталога</a></div>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                    @if ($products->isNotEmpty())
                        <div class="row">
                            <div class="col-lg-5"></div>
                            <div class="col-lg-7">
                                <div class="d-flex justify-content-between border-bottom border-3 border-warning pb-2 mb-3">
                                    <div>Сумма заказа</div>
                                    <div class="fw-semibold fs-5"><span
                                            class="amount">{{ number_format($amount, 0, 0, ' ') }}</span> ₽.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @if ($products->isNotEmpty())
            <section>
                <div class="card card-body">
                    <h2 class="h4">Оформить заказ</h2>
                    <hr class="mb-4">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="p-3">
                                <h4 class="border-bottom">Контактные данные</h4>
                                <div class="pe-5">
                                    <input type="hidden" name="api_token" id="api_token"
                                        value="@if (Auth::check()) {{ Auth::user()->api_token }} @endif">
                                    <div class="mb-2">
                                        <label for="name" class="form-label">Ваше имя * </label>
                                        <input value="@if (Auth::check()) {{ Auth::user()->name }} @endif"
                                            type="text" class="form-control" id="name">
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone" class="form-label">Телефон для связи *</label>
                                        <input value="@if (Auth::check()) {{ Auth::user()->phone }} @endif"
                                            type="text" class="form-control" id="phone">
                                    </div>
                                    <div class="mb-2">
                                        <label for="email" class="form-label">Почта для связи</label>
                                        <input value="@if (Auth::check()) {{ Auth::user()->email }} @endif"
                                            type="email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-3">
                                <h4 class="border-bottom">Адрес доставки заказа</h4>
                                <div class="pe-5">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-2">
                                                <label for="area" class="form-label">Город</label>
                                                <input
                                                    value="@if (Auth::check()) {{ Auth::user()->area }} @endif"
                                                    type="text" class="form-control" id="city">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-2">
                                                <label for="city" class="form-label">Улица</label>
                                                <input
                                                    value="@if (Auth::check()) {{ Auth::user()->city }} @endif"
                                                    type="text" class="form-control" id="street">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-2">
                                                <label for="address_index" class="form-label">Дом/Корпус</label>
                                                <input
                                                    value="@if (Auth::check()) {{ Auth::user()->address_index }} @endif"
                                                    type="number" class="form-control" id="house">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-2">
                                                <label for="address_index" class="form-label">Квартира</label>
                                                <input
                                                    value="@if (Auth::check()) {{ Auth::user()->address_index }} @endif"
                                                    type="number" class="form-control" id="apart">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-2">
                                                <label for="address" class="form-label">Комментарий</label>
                                                <textarea name="address" id="comment" rows="3" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-0 col-lg-4">
                            <div>
                                <h4 class="border-bottom mb-4">Способ доставки</h4>
                                <select name="" id="delivery" class="form-select mb-3">
                                    <option value="0" selected="selected">Курьером в черте города</option>
                                    <option value="0">Самовывоз ТЦ "Мармелад"</option>
                                    <option value="500">Курьером по Новгородской области</option>
                                    <option value="0">Самовывоз ТД "Русь"</option>
                                </select>
                                <button class="badge text-bg-light py-3 rounded-0 fs-5 fw-normal w-100 border">Стоимость
                                    доставки: <span class="fw-semibold"><span class="delivery-text">0</span>
                                        рублей</span></button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <h4 class="border-bottom mb-4">Cпособ оплаты</h4>
                                <select name="" id="delivery" class="form-select mb-3">
                                    <option value="0" selected="selected">Наличными курьеру/кассиру
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <h4 class="border-bottom mb-4">Общая цена: </h4>
                                <div class="d-flex justify-content-between fs-6 mb-1">
                                    <div>Товары:</div>
                                    <div class="fw-semibold"><span
                                            class="amount">{{ number_format($amount, 0, 0, ' ') }}</span> ₽.</div>
                                </div>
                                <div class="d-flex justify-content-between fs-6">
                                    <div>Доставка:</div>
                                    <div class="fw-semibold"><span class="delivery-text">{{ 0 }}</span>
                                        рублей</div>
                                </div>
                                <div class="d-flex justify-content-between fs-5 mt-4">
                                    <div>Итого:</div>
                                    <div class="fw-semibold"><span
                                            id="amount-with-delivery">{{ number_format($amount, 0, 0, ' ') }}</span>
                                        рублей</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center mt-auto py-4">
                                <p>* Обязательные поля</p>
                                <p>Нажимая на кнопку Оформить заказ, Вы соглашаетесь с <a href="">правилами
                                        обработки данных</a></p>
                                <button class="btn btn-dark" id="create-order"
                                    @if (Auth::check()) data-user="{{ Auth::user()->id }}" @endif>Оформить
                                    заказ</button>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
