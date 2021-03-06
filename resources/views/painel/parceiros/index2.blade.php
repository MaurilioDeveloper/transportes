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
    <h1>CONSULTAR DADOS DE PARCEIROS</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-briefcase"></i> Parceiros</li>
    </ol>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div style="display: none;" id="dialog-confirm" title="Deletar">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente
            excluir este parceiro?</p>
    </div>
    <!-- Main content -->
    {{--<section class="content">--}}
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary fadeIn animated' style="visibility: visible; animation-name: fadeIn;">
                    <div style="display: none;" id="dialog-confirm" title="Deletar">
                        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja
                            realmente excluir esse Parceiro?</p>
                    </div>

                    <div class='box-header'>Listagem de Dados</div>

                    <!--<div class='col-lg-8'>
                        <a class="btn btn-success btn-sm"
                           {{--href="{{ route('parceiros.create',['pessoa' => \App\Models\Parceiro::PESSOA_FISICA]) }}"><i--}}
                                    class="fa fa-user-secret"></i> Pessoa Física</a>
                        <a class="btn btn-success btn-sm"
                           {{--href="{{ route('parceiros.create',['pessoa' => \App\Models\Parceiro::PESSOA_JURIDICA]) }}"><i--}}
                                    class="fa fa-briefcase"></i> Pessoa Jurídica</a>
                    </div>-->
                    <br/>
                    <br/>
                    @if(isset($palavraPesquisa))
                        <input type="hidden" id="palavraPesquisa" value="{{$palavraPesquisa}}" />
                    @endif
                    <div class='box-body'>

                            <table class="table table-bordered" id="parceiros-table" style="width: 100%">
                                <thead>
                                    <tr style='background: #2e6da4; color: white;'>
                                        <th style="text-align: center;">Nome</th>
                                        {{--<th style="text-align: center;">CNPJ/CPF</th>--}}
                                        {{--<th>Data Nasc</th>--}}
                                        <th style="text-align: center">Email</th>
                                        <th style="text-align: center;">Telefone</th>
                                        {{--<th style="text-align: center;">CEP</th>--}}
                                        {{--<th>Sexo</th>--}}
                                        <th style="text-align: center;">Endereço</th>
                                        <th style="text-align: center;">Bairro</th>
                                        {{--<th>Numero</th>--}}
                                        <th style="text-align: center;">Cidade</th>
                                        {{--<th style="text-align: center;">Estado</th>--}}
                                        <th style="width: 140px; text-align: center;">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    {{--</section>--}}
    <!-- /.content -->


@section('scripts-footer')
    {{--<script src="{{url('/assets/js/datatables-lists/lista-parceiro.js')}}"></script>--}}
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