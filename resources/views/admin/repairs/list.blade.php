@extends('layouts.admin')

@section('title')
    Заявки на ремонт
@endsection

@section('script-code')
    <script>
        $(".btn-remove").click(function() {
            const modalConfirm = new bootstrap.Modal('#modal-confirm');
            modalConfirm.show();
            $("#repair-id-text").text(this.dataset.repairId)
            $("#btn-confirm-remove").attr("data-repair-id", this.dataset.repairId)
        })

        $("#btn-confirm-remove").click(function() {
            $.ajax({
                url: "{{ route('api.admin.repairs.remove') }}",
                method: 'post',
                data: {
                    repair: this.dataset.repairId,
                },
                success: response => {
                    showAlert([response.message], 'alert-success')
                    localStorage.setItem("message-success", response.message)
                    location.reload();
                },
                error: response => {
                    console.log(response)
                }
            })
        })
    </script>
@endsection

@section('admin')
    <div class="container-fluid">
        <section class="mb-5">
            <div class="col-lg-7">
                <h1>Заявки на ремонт</h1>
                <small>Всего заявок: {{ $countRepairs }}</small>
            </div>
        </section>
        {{-- <section class="mb-3">
            <form action="{{ route('admin.orders.list') }}" method="get">
                <div class="d-flex flex-wrap">
                    <div class="me-2">
                        <input type="text" name="id" value="{{ old('value') }}" class="form-control"
                            placeholder="Идентификатор">
                    </div>
                    <div class="me-2">
                        <select name="sort" class="form-select">
                            <option @if (old('sort') == 'created_at|desc') selected @endif value="created_at|desc">Сначала новые
                            </option>
                            <option @if (old('sort') == 'created_at|asc') selected @endif value="created_at|asc">Сначала старые
                            </option>
                        </select>
                    </div>
                    <div class="me-2">
                        <select name="status" class="form-select">
                            <option value="" selected class="text-muted">Статус заказа</option>
                            <option @if (old('status') == 'created') selected @endif value="created">Новый</option>
                            <option @if (old('status') == 'cancaled') selected @endif value="cancaled">Отменен</option>
                            <option @if (old('status') == 'in_road') selected @endif value="in_road">В пути</option>
                            <option @if (old('status') == 'expecting') selected @endif value="expecting">Ожидает</option>
                            <option @if (old('status') == 'completed') selected @endif value="completed">Доставлен</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <a href="{{ route('admin.orders.list') }}" class="btn btn-outline-dark">сбросить</a>
                        <button type="submit" class="btn btn-dark">применить</button>
                    </div>
                </div>
            </form>
        </section> --}}
        <section>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">номер</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Вид телефона</th>
                        <th scope="col">Описание проблемы</th>
                        <th scope="col">Дата</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($repairs as $repair)
                        <tr>
                            <th scope="row">{{ $repair->id }}</th>
                            <td>{{ $repair->name }}</td>
                            <td>{{ $repair->phone }}</td>
                            <td>{{ $repair->mobile ? $repair->mobile : 'Не указан' }}</td>
                            <td>{{ $repair->description ? $repair->description : 'Не указано' }}</td>
                            {{-- <td>{{ $category->title }}</td> --}}
                            <td>{{ date_format(date_create($repair->created_at), 'd.m H:i') }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-remove"
                                    data-repair-id="{{ $repair->id }}">Удалить</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="fs-5 text-center py-5">
                                <div class="mb-3">На данный момент нет заявок на ремонт</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection


@section('modal')
    <div class="modal fade" id="modal-confirm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-warning">
                    <h1 class="modal-title fs-5" id="modal-label">Подтвердите действие</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modal-confirm-text">
                    <div>Вы действительно хотите удалить заявку на ремонт с номером <span class="fw-semibold"
                            id="repair-id-text">0</span></div>
                    <div><b></b></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger"data-bs-dismiss="modal" id="btn-confirm-remove"
                        data-repair-id="0">Удалить</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
