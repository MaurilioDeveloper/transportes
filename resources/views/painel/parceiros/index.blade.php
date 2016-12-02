@extends('painel.template.template')

@section('styles-head')
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/autoFill.bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/buttons.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/colReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/fixedColumns.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/fixedHeader.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/keyTable.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/responsive.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/rowReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/scroller.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/select.bootstrap.min.css')}}"/>
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
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente excluir este parceiro?</p>
</div>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class='box box-primary'>
                <div style="display: none;" id="dialog-confirm" title="Deletar">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente excluir esse visitante?</p>
                </div>

                <div class='box-header'>Listagem de Dados</div>
                <div class='col-lg-8'>
                    <a class="btn btn-success btn-sm" href="{{ route('parceiros.create',['pessoa' => \App\Parceiro::PESSOA_FISICA]) }}"><i class="fa fa-user-secret"></i> Pessoa Física</a>
                    <a class="btn btn-success btn-sm" href="{{ route('parceiros.create',['pessoa' => \App\Parceiro::PESSOA_JURIDICA]) }}"><i class="fa fa-briefcase"></i> Pessoa Jurídica</a>
                </div>
                <br/>
                <br/>
                <div class='box-body'>
                    <table class='table table-bordered display ui table' id="parceiros-table">
                        <thead>
                        <tr style='background: #2e6da4; color: white;'>
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
                            <th style="text-align: center; display: inline-block">Açao</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@forelse($parceiros as $parceiro)--}}
                            {{--<tr class="warning">--}}
                                {{--<td>{{ $parceiro->nome }}</td>--}}
                                {{--<td>{{ $parceiro->documento }}</td>--}}
                                {{--<td>{{ $parceiro->data_nasc }}</td>--}}
                                {{--<td>{{ $parceiro->email }}</td>--}}
                                {{--<td>{{ $parceiro->telefone }}</td>--}}
                                {{--<td>{{ $parceiro->sexo }}</td>--}}
                                {{--<td>{{ $parceiro->endereco }}</td>--}}
                                {{--<td>{{ $parceiro->numero }}</td>--}}
                                {{--<td>{{ $parceiro->cidade }}</td>--}}
                                {{--<td>{{ $parceiro->estado }}</td>--}}
                                {{--<td>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<a class='btn btn-primary btn-sm' href="{{route('parceiros.edit', ['$parceiro' => $parceiro->id])}}"><i class='fa fa-edit'></i> </a>--}}
                                        {{--<form method="POST" action="{{route('parceiros.destroy',['parceiro' => $parceiro->id])}}">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--{{ method_field('DELETE') }}--}}
                                            {{--<button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i> </button>--}}
                                        {{--</form>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@empty--}}
                            {{--<td colspan="7"> Nenhum Dado Cadastrado</td>--}}
                        {{--@endforelse--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


@section('scripts-footer')
    <script src="{{url('/assets/js/jquery.blockUI.js')}}"></script>
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
    <script src="{{url('/assets/js/list-parceiro.js')}}"></script>
@endsection
@endsection