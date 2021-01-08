@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('content')
    <div class="card mb-0">
        <div class="card-header">
            <div class="row flex-nowrap">
                <div class="col-md-6 d-flex">
                    <h4 class="align-self-center">Dashboard</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <form method="POST">
                    @csrf
                    <label for="filter-date">Período:</label>
                    <select name="filter-date" id="filter-date" class="form-select">
                        <ul>
                            <li><option value="-1 day" @if($filterDate === '-1 day') selected @endif>
                                Último dia
                            </option></li>
                            <li><option value="-1 week" @if($filterDate === '-1 week') selected @endif>
                                Última semana
                            </option></li>
                            <li><option value="-1 month" @if($filterDate === '-1 month') selected @endif>
                                Último mês
                            </option></li>
                            <li><option value="-3 months" @if($filterDate === '-3 months') selected @endif>
                                Último trimestre
                            </option></li>
                            <li><option value="-6 months" @if($filterDate === '-6 months') selected @endif>
                                Último semestre
                            </option></li>
                        </ul>
                    </select>
                    <input type="submit" hidden>
                    </form>
                </div>
            </div>
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        window.onload = function() {
            let ctx = document.getElementById('pagePie').getContext('2d');

            window.pagePie = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: {{$pageValues}},
                        backgroundColor: {!! $pageColors !!}
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

            let dateFilter = document.querySelector('#filter-date');
            let dateFilterValue = dateFilter.value;
            let dateFilterForm = dateFilter.closest('form');
            
            dateFilter.addEventListener('change', function(){
                swal({
                    title: "Deseja filtrar a data?",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                }).then(confirmation => {
                    if(confirmation){
                        dateFilterForm.submit();
                    } else {
                        dateFilter.value = dateFilterValue;
                    };
                });
            });
        };

    </script>
@endsection
