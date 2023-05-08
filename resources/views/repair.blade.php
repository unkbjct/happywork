@extends('layouts.main')

@section('title')
    Ремонт
@endsection

@section('script-code')
    <script>
        $("#btn-submit-applicant").click(function() {
            $.ajax({
                url: "{{ route('api.repair.applicant') }}",
                method: 'post',
                data: {
                    name: $("#name").val(),
                    phone: $("#phone").val(),
                    mobile: $("#mobile").val(),
                    description: $("#description").val(),
                },
                success: response => {
                    showAlert([response.message], 'alert-success')
                    $(this).remove()
                },
                error: response => {
                    console.log(response)
                    showAlert(response.responseJSON.data.errors, 'alert-danger')
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
                    <li class="breadcrumb-item">Ремонт</li>
                </ol>
            </nav>
        </section>
        <section>
            <div class="card card-body">
                <h1 class="h3">Ремонт</h1>
                <hr class="mb-5">
                <div class="mb-5">
                    <div class="row gy-5">
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-center">
                                <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    fill="var(--bs-warning)" class="bi bi-nut" viewBox="0 0 16 16">
                                    <path
                                        d="m11.42 2 3.428 6-3.428 6H4.58L1.152 8 4.58 2h6.84zM4.58 1a1 1 0 0 0-.868.504l-3.428 6a1 1 0 0 0 0 .992l3.428 6A1 1 0 0 0 4.58 15h6.84a1 1 0 0 0 .868-.504l3.429-6a1 1 0 0 0 0-.992l-3.429-6A1 1 0 0 0 11.42 1H4.58z" />
                                    <path
                                        d="M6.848 5.933a2.5 2.5 0 1 0 2.5 4.33 2.5 2.5 0 0 0-2.5-4.33zm-1.78 3.915a3.5 3.5 0 1 1 6.061-3.5 3.5 3.5 0 0 1-6.062 3.5z" />
                                </svg>
                                <span class="fs-5 text-center">Ремонт любой сложности</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-center">
                                <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    fill="var(--bs-warning)" class="bi bi-clock" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                <span class="fs-5 text-center">Починим в кратчайшие сроки</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-center">
                                <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    fill="var(--bs-warning)" class="bi bi-wallet2" viewBox="0 0 16 16">
                                    <path
                                        d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                                </svg>
                                <span class="fs-5 text-center">Оплата по карте или наличными</span>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-center">
                                <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    fill="var(--bs-warning)" class="bi bi-shield-check" viewBox="0 0 16 16">
                                    <path
                                        d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                                    <path
                                        d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                </svg>
                                <span class="fs-5 text-center">Гарантия 1 год на все работы</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-center">
                                <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    fill="var(--bs-warning)" class="bi bi-wifi" viewBox="0 0 16 16">
                                    <path
                                        d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.444 12.444 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.518.518 0 0 0 .668.05A11.448 11.448 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049z" />
                                    <path
                                        d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.455 9.455 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065zm-2.183 2.183c.226-.226.185-.605-.1-.75A6.473 6.473 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.478 5.478 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091l.016-.015zM9.06 12.44c.196-.196.198-.52-.04-.66A1.99 1.99 0 0 0 8 11.5a1.99 1.99 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z" />
                                </svg>
                                <span class="fs-5 text-center">Комфортная зона ожидания с WiFi</span>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                </div>
                <hr>
                <div class="px-4">
                    <div class="h4 text-center mb-4">Заполните форму и мы вам перезвоним</div>
                    <div class="card card-body mx-auto" style="max-width: 500px">
                        <div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Ваше имя *</label>
                                <input type="text"
                                    @if (Auth::check()) value="{{ Auth::user()->name }}" @endif
                                    class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Номер телефона *</label>
                                <input type="text"
                                    @if (Auth::check()) value="{{ Auth::user()->phone }}" @endif
                                    class="form-control" id="phone">
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Модель телефона</label>
                                <input type="text" class="form-control" id="mobile">
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Модель телефона</label>
                                <textarea id="description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-dark ms-auto"
                                    id="btn-submit-applicant">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
