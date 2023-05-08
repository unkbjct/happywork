@extends('layouts.admin')

@section('title')
    Пользователи
@endsection

@section('script-code')
    <script>
        $(".btn-change-user").click(function() {
            $.ajax({
                url: "{{ route('api.admin.users.edit') }}",
                method: 'post',
                data: {
                    user: this.dataset.userId,
                    status: this.dataset.setStatus,
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
                <h1>Пользователи</h1>
            </div>
        </section>
        <section class="mb-3">
            <form action="{{ route('admin.users.list') }}" method="get">
                <div class="d-flex flex-wrap">
                    <div class="me-2">
                        <input type="text" name="id" value="{{ old('id') }}" class="form-control"
                            placeholder="Идентификатор">
                    </div>
                    <div class="me-2">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                            placeholder="Телефон">
                    </div>
                    <div class="me-2">
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="Почта">
                    </div>
                    <div class="me-2">
                        <select name="status" class="form-select">
                            <option value="" selected class="text-muted">Роль</option>
                            <option @if (old('status') == 'ADMIN') selected @endif value="ADMIN">Администратор</option>
                            <option @if (old('status') == 'USER') selected @endif value="USER">Пользователь</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <a href="{{ route('admin.users.list') }}" class="btn btn-outline-dark">сбросить</a>
                        <button type="submit" class="btn btn-dark">применить</button>
                    </div>
                </div>
            </form>
        </section>
        <section>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">номер</th>
                        <th scope="col">Роль</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Почта</th>
                        <th scope="col">Дата регистрации</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @if ($user->id == Auth::user()->id)
                            @continue
                        @endif
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->status == 'ADMIN' ? 'Администратор' : 'Пользователь' }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ date_format(date_create($user->created_at), 'd.m.Y') }}</td>
                            <td>
                                @if ($user->status == 'ADMIN')
                                    <button class="btn btn-danger btn-sm btn-change-user" data-set-status="USER"
                                        data-user-id="{{ $user->id }}">Сделать обычным пользователем</button>
                                @else
                                    <button class="btn btn-danger btn-sm btn-change-user" data-set-status="ADMIN"
                                        data-user-id="{{ $user->id }}">Сделать администратором</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="fs-5 text-center py-5">
                                <div class="mb-3">Пользователи не найдены</div>
                                <a href="{{ route('admin.users.list') }}" class="btn btn-dark btn-sm">Сбросить
                                    фильтры</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection
