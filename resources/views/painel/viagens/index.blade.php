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
    <!-- Content Header (Page header) -->
    {{--<section class="content-header">--}}
        <h1>CONSULTAR VIAGENS</h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><i class="fa fa-plane"></i> Viagens</li>
        </ol>
    {{--</section>--}}
@endsection

@section('content')

    <!-- Main content -->
    {{--<section class="content">--}}
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary'>

                    <div class='box-header'>Listagem de Dados</div>
                    <div class='col-lg-8'>
                        <a class="btn btn-success btn-sm" href="{{route('cadastrarViagens')}}"><i
                                    class="fa fa-plus-square"></i> Cadastrar Viagem</a>
                    </div>
                    <br/>
                    <br/>
                    <div class='box-body'>
                        <table class="table table-bordered" id="lista-viagens">
                            <thead>
                                <tr style="background: #2e6da4; color: white">
                                    <th>Nome Parceiro</th>
                                    <th>Modelo</th>
                                    <th>Identificação</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    {{--<th style="width: 140px">Ações</th>--}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="warning">

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
    <script src="{{url('/assets/js/datatable-lists/list-viagem.js')}}"></script>
@endsection
@endsection