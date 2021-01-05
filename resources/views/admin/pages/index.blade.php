@extends('adminlte::page')

@section('title', 'Páginas')

@section('content_header')
    <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">Nova Página</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Minhas Páginas</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th width="200">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->title }}</td>
                            <td>
                                <a href="" target="_blank" class="btn btn-sm btn-success">Ver</a>
                                <a href="{{ route('pages.edit', ['page' => $page->id]) }}"
                                    class="btn btn-sm btn-info">Editar</a>
                                <form method="POST" action="{{ route('pages.destroy', ['page' => $page->id]) }}"
                                    class="d-inline" onsubmit="return confirm('Deseja realmente excluir essa página?')">
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
    {{ $pages->links('pagination::bootstrap-4') }}
@endsection
