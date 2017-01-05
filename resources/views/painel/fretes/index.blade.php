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
                <div class='box box-primary'>

                    <div class='box-header'>Listagem de Dados</div>
                    <div class='col-lg-8'>
                        <a class="btn btn-success btn-sm" href="{{ route('adicionarFrete')}}"><i
                                    class="fa fa-briefcase"></i> Cadastrar Frete</a>
                    </div>
                    <br/>
                    <br/>
                    <div class='box-body'>
                        <div style="display: none;" id="dialog-confirm" title="Deletar">
                            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja
                                realmente excluir esse frete?</p>
                        </div>
                        {{--<div ng-controller="HttpGetController">--}}
                        <div>
                            {{--<div style="float: right"><label>Pesquisar: <input class="" ng-model="searchText"></label></div>--}}
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
                                    <th  style="text-align: center;">Tipo</th>
                                    <th  style="text-align: center;">Status</th>
                                    <th style="text-align: center; width: 160px">Ação</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                {{--@if(isset($fretes) && count($fretes) > 0)--}}
                                {{--@verbatim--}}
                                {{--<tr ng:repeat="f in fretes | orderBy:sortField:reverseOrder | filter : searchText">--}}
                                    {{--<td>{{ f.nome }}</td>--}}
                                    {{--<td>{{ f.cidade_origem }}</td>--}}
                                    {{--<td>{{ f.cidade_destino }}</td>--}}
                                    {{--<td>{{ f.tipo }}</td>--}}
                                    {{--<td>{{ f.status }}</td>--}}
                                    {{--<td>--}}
                                        {{--<a href="fretes/edit/{{ f.id }}" id-frete="{{ f.id }}" class="btn btn-primary btn-sm" style="display: inline-block"><i class="fa fa-edit"></i> Editar</a>--}}
                                        {{--<a href="" id-frete="{{f.id}}" class="btn btn-danger btn-sm editor_remove"><i class="fa fa-trash"></i> Deletar</a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--@endverbatim--}}
                                {{--@else--}}
                                    {{--<td colspan="6" style="text-align: center">Nenhum dado cadastrado</td>--}}
                                {{--@endif--}}
                                {{--
                                @forelse($fretes as $frete)
                                <tr class="warning">
                                    <td>{{ $frete->nome }}</td>
                                    <td>{{ $frete->cidade_origem}}</td>
                                    <td>{{ $frete->cidade_destino }}</td>
                                    <td>{{ $frete->tipo}}</td>
                                    <td>{{ $frete->status}}</td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm" style=""><i class="fa fa-edit"></i> Editar</a>
                                        <a href="" id-parceiro="{{$frete->id}}}" class="btn btn-danger btn-sm editor_remove" style=""><i class="fa fa-trash"></i> Deletar</a>
                                    </td>
                                </tr>
                                @empty
                                    <td colspan="7"> Nenhum Dado Cadastrado</td>
                                @endforelse
                                --}}
                                {{--</tbody>--}}
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
@endsection
@endsection