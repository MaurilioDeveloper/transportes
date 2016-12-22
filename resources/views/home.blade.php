@extends('painel.template.template')

@section ('styles-head')

@endsection

<!-- ** Dashboard Index ** -->
{{--@section('title')--}}
{{--<h1>Dashboard</h1>--}}
{{--@stop--}}

@section('breadcrumb')

    <!-- Content Header (Page header) -->
    {{--<section class="content-header">--}}
    <h1><i class="fa fa-dashboard"></i> Dashboard</h1>

    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
    {{--</section>--}}

@endsection

@section('content')




    <input type="hidden" value="{{$freteEdicao}}" id="freteEd"/>
    <input type="hidden" value="{{$freteAc}}" id="freteAc"/>
    <input type="hidden" value="{{$freteAe}}" id="freteAe"/>
    <input type="hidden" value="{{$freteEt}}" id="freteEt"/>
    <input type="hidden" value="{{$freteE}}" id="freteE"/>
    <input type="hidden" value="{{$freteC}}" id="freteC"/>

    {{--</section>--}}
    <!-- /.content -->
    <!-- Main content -->
    {{--<section class="content">--}}
    <div class="row">
        <div class="content">
        {{--<div class="col-md-12">--}}
            <div class='box box-primary col-md-12'>

                <div class='box-header'></div>

                <br/>
                <br/>
                <div class='box-body col-md-6'>
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Fretes</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body no-padding" style="display: block;">

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="pad">

                                        <div id="piechart_3d" style="width: 600px; height: 400px;"></div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- /.row -->
                    </div>
                </div>
                <div class="box-body col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Listagem de Fretes</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body no-padding" style="display: block;">
                            <table class="table table-bordered">
                                <tr style="background: #0d3625; color: white">
                                    <th>Nome Parceiro</th>
                                    <th>Tipo do Item</th>
                                    <th style="width: 180px">Data Prevista Inicial</th>
                                </tr>
                                @forelse($tableDash as $freteDash)
                                    @if($freteDash->data_inicio > date('Y-m-d'))
                                        <tr class="success">
                                    @else
                                        <tr style="background: red; color: white">
                                    @endif
                                        <td>{{$freteDash->nome}}</td>
                                        <td>{{$freteDash->tipo}}</td>

                                        @if($freteDash->data_inicio > date('Y-m-d'))
                                            <td>{{date('Y-m-d') - $freteDash->data_inicio}} dias</td>
                                        @else
                                            <td style=""><span style="font-size: 15px" class="label label-danger">Atrasado</span></td>
                                        @endif

                                        @empty
                                            <td style="text-align: center" colspan="3">Nenhum dado Cadastrado</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">


        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {

            var freteEd = document.getElementById("freteEd").value;
            var freteAc = $('#freteAc').val();
            var freteAe = $('#freteAe').val();
            var freteEt = $('#freteEt').val();
            var freteE = $('#freteE').val();
            var freteC = $('#freteC').val();
            console.log(freteAc, freteE, freteEd, freteAe, freteEt, freteC);
            var data = google.visualization.arrayToDataTable([
                ['Task', ''],
                ['Em Edição', parseInt(freteEd)],
//                console.log(['Em Edição',   parseInt(freteEd)]),
                ['Aguardando Coleta', parseInt(freteAc)],
                ['Aguardando Embarque', parseInt(freteAe)],
                ['Em trânsito', parseInt(freteEt)],
                ['Entregue', parseInt(freteE)],
                ['Cancelado', parseInt(freteC)]
            ]);
//            console.log(data);

            var options = {
                title: 'Fretes por STATUS',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>


@endsection