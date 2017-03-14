@extends('painel.template.template')

@section('styles-head')
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/autoFill.bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/buttons.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/colReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/fixedColumns.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/fixedHeader.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/keyTable.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/responsive.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/rowReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/scroller.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/select.bootstrap.min.css')}}"/>
@endsection

@section('breadcrumb')
    <h1>CONSULTAR FRETES</h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-briefcase"></i> Fretes</li>
    </ol>
@endsection

@section('content')

    <!-- Main content -->
    {{--<section class="content" >--}}
        {{--<div class="row" ng-app="app">--}}
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary fadeIn animated' style="visibility: visible; animation-name: fadeIn;">

                    <div class='box-header'>Listagem de Dados</div>
                    <div class='col-lg-8'>
                        <a class="btn btn-success btn-sm" href="{{ route('adicionarFrete')}}"><i
                                    class="fa fa-briefcase"></i> Cadastrar Frete</a>
                    </div>
                    <br/>
                    <br/>

                    {!! Form::open(['route' => 'filtrarFrete', 'name' => 'form']) !!}

                    <div class="form-group col-md-10">
                        <select class="form-control" name="status">
                            <option value="0">Filtrar por Status</option>
                            @foreach(\App\Models\Frete::STATUS as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(isset($status))
                        <input type="hidden" value="{{$status}}" id="statusPesquisa" />
                    @endif

                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                    </div>

                    {!! Form::close() !!}


                    {{--<form action="/painel/fretes?exibirEntregues=" name="ff">--}}
                        {{--<input value="{{csrf_token()}}" type="hidden"/>--}}
                        <div class="form-group col-md-12">
                            <input type="checkbox" onclick="enableEntregue()" id="filtroExibirEntregue"/>
                            <label for="filtroExibirEntregue">Exibir fretes entregues</label>
                        </div>
                    {{--</form>--}}

                    <div class='box-body'>
                        <div style="display: none;" id="dialog-confirm" title="Deletar">
                            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja
                                realmente excluir esse frete?</p>
                        </div>
                        {{--<div ng-controller="HttpGetController">--}}
                        <div>

                            <table class='table table-bordered' id="fretes-table-two">
                                <thead>
                                <tr style='background: #2e6da4; color: white;'>
                                    {{--<th  ng-click="sortBy('nome')" style="text-align: center;">Parceiro</th>--}}
                                    {{--<th  ng-click="sortBy('cidade_origem')" style="text-align: center;">Cidade Origem</th>--}}
                                    {{--<th  ng-click="sortBy('cidade_destino')" style="text-align: center;">Cidade Destino</th>--}}
                                    {{--<th  ng-click="sortBy('tipo')" style="text-align: center;">Tipo</th>--}}
                                    {{--<th  ng-click="sortBy('status')" style="text-align: center;">Status</th>--}}
                                    <th  style="text-align: center;">Parceiro</th>
                                    <th  style="text-align: center;">Cidade Origem</th>
                                    <th  style="text-align: center;">Cidade Destino</th>
                                    <th  style="text-align: center">Identificação</th>
                                    <th  style="text-align: center;">Tipo</th>
                                    <th  style="text-align: center;">Status</th>
                                    <th style="text-align: center; width: 160px">Ação</th>
                                </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    {{--</section>--}}
    <!-- /.content -->


@section('scripts-footer')
    {{--<script src="{{url('/assets/js/angular-lists/lista-fretes.js')}}"></script>--}}
    <script src="{{url('/assets/js/vendor/jquery.blockUI.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/datatables.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/jszip.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/vfs_fonts.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.autoFill.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/autoFill.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.colVis.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.colReorder.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.fixedColumns.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/responsive.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.rowReorder.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.select.min.js')}}"></script>
    <script src="{{url('/assets/js/datatable-lists/list-frete.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
@endsection
@endsection