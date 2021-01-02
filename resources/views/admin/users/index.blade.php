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
                                <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}" class="d-inline" onsubmit="return confirm('Deseja realmente excluir esse usuário?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{ $users->links('pagination::bootstrap-4') }}
@endsection
