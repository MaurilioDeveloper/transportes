@extends('painel.template.template')

@section('content')
<section class="content-header">
    @if ( isset($usuario->id) )
        <h1>EDIÇÃO DO USUÁRIO</h1>
    @else
         <h1>CADASTRO DE USUÁRIO</h1>
    @endif
   
    <ol class="breadcrumb">
        <li><a href="starter.html"><i class="fa fa-dashboard"></i> Home</a></li>
        @if ( isset($usuario->id) )
           <li class="active">Edição do Usuário</li>
        @else
           <li class="active">Cadastro de Usuário</li>
        @endif
    </ol>
</section>
<div class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Os campos com * são obrigatórios</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                @if(isset($errors) && count($errors) > 0 )
                <div class="alert alert-warning">
                    @foreach($errors->all() as $error)
                    <span style="color: black">{{$error}}</span> <br/>
                    @endforeach
                </div>
                @endif
                @if ( isset($usuario->id) )
                <form name='form' method='post' action='/m1-transportes/public/painel/usuarios/{{$usuario->id}}'>
                    <input name="_method" value="PUT" type="hidden">
                    @else
                    <form name='form' method='post' action='/m1-transportes/public/painel/usuarios'>
                        @endif
                        {{ csrf_field() }}

                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="Nome">Nome *</label>
                                <input type="text" value="@if(isset($usuario->name)){{$usuario->name}}@else{{old('name')}}@endif" name='name' placeholder="Insira o Nome" class='form-control'>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail">E-mail *</label>
                                <input type="text" value="@if(isset($usuario->email)){{$usuario->email}}@else{{old('email')}}@endif" name='email' placeholder="Insira um Email" class='form-control'>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="Senha">Senha *</label>
                                <input type="password" value="{{old('password')}}" name='password' placeholder="Insira uma Senha" class='form-control'>
                            </div>
                        </div>
                         <div class="box-footer col-md-6">
                            <button type="submit" class="btn btn-primary">Salvar</button>&nbsp;&nbsp;<button type="reset" class="btn">Limpar</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection