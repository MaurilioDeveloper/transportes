@extends('painel.template.template')

@section ('styles-head')
    <script>console.log($("svg > .highcharts-credits").val());
        $("#highcharts-1qcd7rk-0 > text").hide();</script>
@endsection

<!-- ** Dashboard Index ** -->
{{--@section('title')--}}
{{--<h1>Dashboard</h1>--}}
{{--@stop--}}

@section('breadcrumb')

    <!-- Content Header (Page header) -->
    {{--<section class="content-header">--}}
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="active"><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
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
            <div class='box box-primary col-md-12 fadeIn animated' style="visibility: visible; animation-name: fadeIn;">

                <div class='box-header'></div>

                <div class='box-body col-md-12'>
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
                                    {{--{{$graficoLocalizacao}}--}}
                                    <div id="container"></div>
                                    <div id="sliders" style="min-width: 310px; max-width: 800px; margin: 0 auto;">
                                        {{--<table>--}}
                                            {{--<tr style="display: inline; margin-left: 16%">--}}
                                                {{--<td style="padding-right: 3%">Angulo alpha</td>--}}
                                                {{--<td><input style="margin-top: 16%" id="alpha" type="range" min="0" max="45" value="15"/> <span id="alpha-value" class="value"></span></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr style="display: inline">--}}
                                                {{--<td style="padding-right: 3%">Angulo Beta</td>--}}
                                                {{--<td><input id="beta" style="margin-top: 16%" type="range" min="-45" max="45" value="15"/> <span id="beta-value" class="value"></span></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr style="display: inline">--}}
                                                {{--<td style="padding-right: 3%">Angula Omega</td>--}}
                                                {{--<td><input style="margin-top: 16%" id="depth" type="range" min="20" max="100" value="50"/> <span id="depth-value" class="value"></span></td>--}}
                                            {{--</tr>--}}
                                        {{--</table>--}}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- /.row -->
                    </div>
                </div>
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

                                        <div id="piechart_3d" style="width: 500px; height: 300px;"></div>
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
                                        <tr style="background: #dd4b39; color: white">
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
                            <center>{!! $tableDash->render() !!}</center>
                        </div>
                    </div>
                </div>
                <div class="box-body col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Fretes em operação</h3>

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
                                <tr style="background: #2e6da4; color: white">
                                    <th>Data</th>
                                    <th>Nome parceiro</th>
                                    <th>Cidade Origem/Destino</th>
                                    <th>Item (Tipo / Identificação)</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                                @forelse($fretesOp as $fp)
                                    <tr class="success" style="cursor: pointer;" onclick="window.location='/painel/fretes/edit/{{$fp->id}}'">
                                        <td>{{implode('/', array_reverse(explode('-',$fp->data_inicio)))}}</td>
                                        <td>{{$fp->nome}}</td>
                                        <td>{{$fp->cidade_origem}} - {{$fp->cidade_destino}}</td>
                                        <td>{{$fp->tipo}} | {{$fp->identificacao}}</td>
                                        <td>{{$fp->status}}</td>
                                        <td><a href="/painel/fretes/edit/{{$fp->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a></td>
                                    </tr>
                                @empty
                                    <tr class="warning"><td colspan="5" style="text-align: center">Nenhum frete em operação</td></tr>
                                @endforelse

                            </table>
                            <span style="float: right">{!! $fretesOp->render() !!}</span>
                        </div>
                    </div>
                </div>
                <div class="box-body col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Viagens em operação</h3>

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
                                <tr style="background: #2e6da4; color: white">
                                    <th>Data</th>
                                    <th>Nome parceiro</th>
                                    <th>Total fretes</th>
                                    <th>Cidade Origem/Destino</th>
                                    <th>Status</th>
                                    <th style="width: 100px">Ação</th>
                                </tr>
                                @forelse($viagensOp as $vp)
                                    <tr class="success"  style="cursor: pointer" onclick="window.location='/painel/viagens/edit/{{$vp->id}}'">
                                        <td>{{implode('/', array_reverse(explode('-',$vp->data_inicio)))}}</td>
                                        <td>{{$vp->nome}}</td>
                                        <td>{{$vp->fretes_viagens}}</td>
                                        <td>{{$vp->cidade_origem}} - {{$vp->cidade_destino}}</td>
                                        <td>{{$vp->status}}</td>
                                        <td><a href="/painel/viagens/edit/{{$vp->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a></td>
                                    </tr>
                                @empty
                                    <tr class="warning">
                                        <td colspan="5" style="text-align: center;">Nenhuma viagem em Operação</td>
                                    </tr>
                                @endforelse
                            </table>
                            <span style="float: right">{!! $viagensOp->render() !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script src="{{url('/assets/js/vendor/highcharts.js')}}"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        $.ajax({
            url: '/painel/list-localizacao',
            type: 'GET',
            async: true,
            dataType: "json",
            success: function (data) {
                for(var i=0; data.length > i;i++){
                    var url = '/painel/fretes/busca-por-localizacao/'+data[i].name;
                    data[i].url = url;
//                    console.log(data[i]);
                }
                localizacaoData(data);

            }
        });
        function localizacaoData(data) {
            // Set up the chart
//            console.log(data[0].name);
            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 6,
                        beta: 6,
                        depth: 100,
                        viewDistance: 45
                    }
                },
                title: {
                    text: 'Localização de Fretes'
                },
                tooltip: {
                    pointFormat: 'Quantidade de fretes: <b>{point.y}</b>'
                },
                subtitle: {
                    text: 'Cidades representando a quantidade de fretes nesta localização'
                },
                xAxis: {
                    type: "category",
                    maxZoom: 1
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: false
                        },
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    name: 'Cidades',
//                    data: [{
//                        name: '<span style="margin-top: 2%"><b>Curitiba</b></span>',
//                        y: 29.9,
//                        url: '/painel/fretes/busca-por-localizacao/Curitiba'
//                    },
//                        71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6],
                    data: data,
                    point: {
                        events: {
                            click: function (e) {
                                location.href = e.point.url;
                                e.preventDefault();
                            }
                        }
                    },
                }]
            });

            function showValues() {
                $('#alpha-value').html(chart.options.chart.options3d.alpha);
                $('#beta-value').html(chart.options.chart.options3d.beta);
                $('#depth-value').html(chart.options.chart.options3d.depth);
            }

            // Activate the sliders
            $('#sliders input').on('input change', function () {
                chart.options.chart.options3d[this.id] = this.value;
                showValues();
                chart.redraw(false);
            });

            showValues();
        }
    </script>
    <script type="text/javascript">
//        $("text.highcharts-credits").hide();
        var freteEd = document.getElementById("freteEd").value;
        var freteAc = $('#freteAc').val();
        var freteAe = $('#freteAe').val();
        var freteEt = $('#freteEt').val();
        var freteE = $('#freteE').val();
        var freteC = $('#freteC').val();

        $(function () {
           Highcharts.chart('piechart_3d', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Fretes por STATUS'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}% | {point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Porcentagem do total',
                    point: {
                        events: {
                            click: function(e) {
                                location.href = e.point.url;
                                e.preventDefault();
                            }
                        }
                    },
                    data: [
                        {name: 'Em Edição', y: parseInt(freteEd), url: '/painel/fretes/busca-por-status/Em Edição'},
                        {name: 'Aguardando Coleta', y: parseInt(freteAc), url: '/painel/fretes/busca-por-status/Aguardando Coleta'},
                        {name: 'Aguardando Embarque', y: parseInt(freteAe), url: '/painel/fretes/busca-por-status/Aguardando Embarque'},
                        {name: 'Em trânsito', y: parseInt(freteEt), url: '/painel/fretes/busca-por-status/Em trânsito'},
                        {name: 'Entregue', y: parseInt(freteE), url: '/painel/fretes/busca-por-status/Entregue'},
                        {name: 'Cancelado', y: parseInt(freteC), url: '/painel/fretes/busca-por-status/Cancelado'}
                    ]
                }]

            });
        });

//console.log(teste);
    </script>
    <!--<script type="text/javascript">


        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {

            var freteEd = document.getElementById("freteEd").value;
            var freteAc = $('#freteAc').val();
            var freteAe = $('#freteAe').val();
            var freteEt = $('#freteEt').val();
            var freteE = $('#freteE').val();
            var freteC = $('#freteC').val();
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

            console.log($("#piechart_3d"));
//            console.log(data.qg);
            $.each(data.qg, function(i, obj){
                console.log(obj.c[0]);
//                console.log(i);
            });

//            console.log(data);

            var options = {
                title: 'Fretes por STATUS',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));

            chart.draw(data, options);

        }
    </script>
-->

@endsection