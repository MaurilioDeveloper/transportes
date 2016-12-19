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

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>CONSULTAR DADOS DE PARCEIROS</h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><i class="fa fa-briefcase"></i> Parceiros</li>
        </ol>
    </section>
    <div style="display: none;" id="dialog-confirm" title="Deletar">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente
            excluir este parceiro?</p>
    </div>
    <!-- Main content -->
    <section class="content" ng-app="app">
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary'>
                    <div style="display: none;" id="dialog-confirm" title="Deletar">
                        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja
                            realmente excluir esse visitante?</p>
                    </div>

                    <div class='box-header'>Listagem de Dados</div>
                    <!--<div class='col-lg-8'>
                        <a class="btn btn-success btn-sm"
                           {{--href="{{ route('parceiros.create',['pessoa' => \App\Parceiro::PESSOA_FISICA]) }}"><i--}}
                                    class="fa fa-user-secret"></i> Pessoa Física</a>
                        <a class="btn btn-success btn-sm"
                           {{--href="{{ route('parceiros.create',['pessoa' => \App\Parceiro::PESSOA_JURIDICA]) }}"><i--}}
                                    class="fa fa-briefcase"></i> Pessoa Jurídica</a>
                    </div>-->
                    <br/>
                    <br/>
                    <div class='box-body'>
                        {{--@if(isset($dataBusca))--}}
                            {{--<div ng-controller="CtrlListaParceirosSearch">--}}
                        {{--@else--}}

                        @if(isset($dadosPesquisa))
                            <table class="table table-bordered">
                                <tr>
                                    <th style="text-align: center;">Nome</th>
                                    <th style="text-align: center;">Cnpj/Cpf</th>
                                    {{--<th>Data Nasc</th>--}}
                                    {{--<th>Email</th>--}}
                                    <th style="text-align: center;">Telefone</th>
                                    {{--<th>Sexo</th>--}}
                                    <th style="text-align: center;">Endereco</th>
                                    {{--<th>Numero</th>--}}
                                    <th style="text-align: center;">Cidade</th>
                                    <th style="text-align: center;">Estado</th>
                                    <th style="width: 160px;">Açao</th>
                                </tr>
                                @forelse ($dadosPesquisa as $dados)
                                <tr class="warning">

{{--                                        @if(count($dados > 0))--}}
                                        <td>{{ $dados->nome }}</td>
                                        <td>{{ $dados->documento }}</td>
                                        <td>{{ $dados->telefone }}</td>
                                        <td>{{ $dados->endereco }}</td>
                                        <td>{{ $dados->cidade }}</td>
                                        <td>{{ $dados->estado }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                            <a class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Deletar</a>
                                        </td>
                                        {{--@else--}}
                                        @empty
                                            <td colspan="7">Nenhum dado Cadastrado</td>
                                        {{--@endif--}}

                                </tr>
                                @endforelse
                            </table>
                        @else
                            <div ng-controller="CtrlListaParceiros">
                        {{--@endif--}}
                            <div style="float: right"><label>Pesquisar: <input class="" ng-model="searchText"></label>
                            </div>

                            {{--<table class='table table-bordered display ui table' id="parceiros-table">--}}
                            <table class='table table-bordered display ui table' id="parceiros-table-two">
                                {{--<thead>--}}
                                <tr style='background: #2e6da4; color: white;'>
                                    <th ng-click="sortBy('nome')"  style="text-align: center;">Nome</th>
                                    <th ng-click="sortBy('documento')"  style="text-align: center;">Cnpj/Cpf</th>
                                    {{--<th>Data Nasc</th>--}}
                                    {{--<th>Email</th>--}}
                                    <th ng-click="sortBy('telefone')"  style="text-align: center;">Telefone</th>
                                    {{--<th>Sexo</th>--}}
                                    <th ng-click="sortBy('endereco')"  style="text-align: center;">Endereco</th>
                                    {{--<th>Numero</th>--}}
                                    <th ng-click="sortBy('cidade')" style="text-align: center;">Cidade</th>
                                    <th ng-click="sortBy('estado')"  style="text-align: center;">Estado</th>
                                    <th style="width: 160px;">Açao</th>
                                </tr>
                                @verbatim
                                <tr ng:repeat="p in parceiros | orderBy:sortField:reverseOrder | filter : searchText">
                                    <td>{{ p.nome }}</td>
                                    <td>{{ p.documento }}</td>
                                    <td>{{ p.telefone }}</td>
                                    <td>{{ p.endereco }}</td>
                                    <td>{{ p.cidade }}</td>
                                    <td>{{ p.estado }}</td>
                                    <td>
                                        <a href="parceiros/edit/{{ p.id }}" id-parceiro="{{ p.id }}"
                                           class="btn btn-primary btn-sm" style="display: inline-block"><i
                                                    class="fa fa-edit"></i> Editar</a>
                                        <a href="" id-parceiro="{{p.id}}" class="btn btn-danger btn-sm editor_remove"><i
                                                    class="fa fa-trash"></i> Deletar</a>
                                    </td>
                                </tr>
                                @endverbatim
                            </table>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->


@section('scripts-footer')
    <script src="{{url('/assets/js/angular-lists/lista-parceiros.js')}}"></script>
    {{--<script src="{{url('/assets/js/angular-lists/lista-parceiros-search.js')}}"></script>--}}
    <script src="{{url('/assets/js/vendor/jquery.blockUI.js')}}"></script>
    <script src="{{url('/assets/js/cadastros/cad-parceiro.js')}}"></script>
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
    <script src="{{url('/assets/js/datatable-lists/list-parceiro.js')}}"></script>
@endsection
@endsection