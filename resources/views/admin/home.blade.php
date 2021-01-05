@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('content')
    <div class="card mb-0">
        <div class="card-header">
            <h4>Dashboard</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $visitsCount }}</h3>
                            <p>Visitas</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-fw fa-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $onlineCount }}</h3>
                            <p>Visitantes Online</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-fw fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pageCount }}</h3>
                            <p>Páginas</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-fw fa-sticky-note"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $userCount }}</h3>
                            <p>Usuários</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-fw fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-header">
                            <h3 class="card-title">Páginas mais visitadas</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="pagePie" class="w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-header">
                            <h3 class="card-title">Sobre o Sistema</h3>
                        </div>
                        <div class="card-body">
                            ...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            let ctx = document.getElementById('pagePie').getContext('2d');

            window.pagePie = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: {{$pageValues}},
                        backgroundColor: '#28a745'
                    }],
                    labels: {!! $pageLabels !!}
                },
                options: {
                    responsive: false,
                    legend: {
                        display: false
                    },
                    animation: {
                        duration: 1000
                    }
                }
            });
        }

    </script>
@endsection
