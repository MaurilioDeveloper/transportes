@extends('painel.template.template')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
                    <table class="table table-bordered" id="usuarios-table">
                        <thead>
                            <tr style="background: #005384; color: white">
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        @foreach($usuarios as $usuario)
                        <tbody>
                            <tr class='warning'>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                <td style="width: 200px">
                                    <a class="btn btn-primary" href="{{url("/painel/usuarios/$usuario->id/edit")}}"><i class="fa fa-edit"></i> Editar</a>
                                    <a class="btn btn-danger editor_remove" id-usuario="{{$usuario->id}}" href=""><i class="fa fa-trash"></i> Deletar</a>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('scripts-footer')
<script src="{{url('/assets/js/jquery.blockUI.js')}}"></script>
<script src="{{url('/assets/js/users.js')}}"></script>
@endsection