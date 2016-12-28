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

    <h1>TIPO DE OCORRÊNCIAS</h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-warning"></i> Tipo de ocorrências</li>
    </ol>

@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary'>
                    <div style="display: none;" id="dialog-confirm" title="Deletar">
                        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja
                            realmente excluir esse tipo de ocorrência?</p>
                    </div>

                    <div class='box-header'>Listagem de Dados</div>
                    <div class='col-lg-8'>
                        <a class="btn btn-warning btn-sm" href="{{ route('adicionarTipoOcorrencia')}}"><i
                                    class="fa fa-warning"></i> Cadastrar Tipo de Ocorrência</a>
                    </div>
                    <br/>
                    <br/>
                    <div class='box-body'>

                        {{--<table class="table table-bordered" id="tipo-ocorrencias-table" style="width: 100%">--}}
                        <table class="table table-bordered" style="width: 100%" id="tipo-ocorrencia">
                            <thead>
                            <tr style='background: #2e6da4; color: white;'>
                                <th style="text-align: center;">Nome</th>
                                <th style="width: 140px;">Açao</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($tipoOcorrencias as $tipoOcorrencia)
                            <tr>
                                <td style="text-align: center">{{$tipoOcorrencia->nome}}</td>
                                <td><a href="tipo-ocorrencias/edit/{{$tipoOcorrencia->id}}" id-tipo-ocorrencia="{{$tipoOcorrencia->id}}" class="btn btn-primary btn-sm" style="display: inline"><i class="fa fa-edit"></i> Editar</a><a href="" id-tipo-ocorrencia="{{$tipoOcorrencia->id}}" class="btn btn-danger btn-sm editor_remove" style="display: inline; margin-left: 4px"><i class="fa fa-trash"></i> Deletar</a></td>
                            </tr>
                            @empty
                            <tr class="warning">
                                <td colspan="2" style="text-align: center">Nenhum dado foi encontrado</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('scripts-footer')
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
    <script src="{{url('/assets/js/datatable-lists/list-tipo-ocorrencias.js')}}"></script>
@endsection
@endsection