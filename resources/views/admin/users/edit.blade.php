@extends('adminlte::page')

@section('title', 'Editar usuário')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>
                <i class="icon fas fa-ban"></i>
                Erro!
            </h5>
            <ul class="mt-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4>Editar usuário</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', ['user' => $user->id]) }}" class="form-horizontal" method="POST">
                @csrf @method('PUT')
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">
                        Nome completo:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">
                        Email:
                    </label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="form-control @error('email') is-invalid @enderror" id="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">
                        Nova senha:
                    </label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">
                        Confirmação da senha:
                    </label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password') is-invalid @enderror" id="password_confirmation">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Salvar" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
