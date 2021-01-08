@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Novo Usuário</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Usuários</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="btn btn-sm btn-info">Editar</a>
                                @if ($loggedId !== intval($user->id))
                                    <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}"
                                        class="d-inline deletion-form">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $users->links('pagination::bootstrap-4') }}

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        let deletionForm = document.querySelector('.deletion-form');

        if (deletionForm) {
            deletionForm.addEventListener('submit', event => {
                event.preventDefault();
                swal({
                    title: "Deseja excluir esse usuário?",
                    text: "Isso não pode ser desfeito",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(confirmation => {
                    if(confirmation){
                        deletionForm.submit();
                    };
                });
            });
        };

    </script>
@endsection
