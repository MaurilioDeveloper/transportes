@extends('painel.template.template')

@section('styles-head')
@endsection


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>CONSULTAR DADOS DOS USUÁRIOS
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Usuários</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class='box'>
                <div style="display: none;" id="dialog-confirm" title="Deletar">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente excluir esse visitante?</p>
                </div>

                <div class='box-header'>Listagem de Dados</div>
                <div class='box-body'>
                    <table class="table table-bordered" id="table-usuarios">
                        <thead>
                            <tr style="background: #005384; color: white">
                                <th>Nome</th>
                                <th>Email</th>
                                <th style='width: 180px'>Ações</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>

@endsection


@section('scripts-footer')

<script src="{{url('/assets/js/vendor/dataTables.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/jquery.blockUI.js')}}"></script>
<script src="{{url('/assets/js/datatable-lists/users.js')}}"></script>
@endsection
