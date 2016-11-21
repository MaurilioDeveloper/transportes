@extends('painel.template.template')

@section('content')
<section class="content-header">
    <h1>
        CADASTRO DE PROPRIETÁRIO - PESSOA FÍSICA</h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cadastro de Proprietário - Pessoa Física</li>
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
                @if ( isset($pessoa->id) )
                <form name='form' method='post' action='/m1-transportes/public/painel/pessoas/{{$pessoa->id}}'>
                    <input name="_method" value="PUT" type="hidden">
                    @else
                    <form name='form' method='post' action='/m1-transportes/public/painel/pessoas'>
                        @endif
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="Nome">Nome Completo *</label>
                                <input type="text" value="@if(isset($pessoa->nome)){{$pessoa->nome}}@else{{old('nome')}}@endif" name='nome' placeholder="Insira o Nome" class='form-control'>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail">E-mail *</label>
                                <input type="text" value="@if(isset($pessoa->email)){{$pessoa->email}}@else{{old('email')}}@endif" name='email' placeholder="Insira um Email" class='form-control'>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="CPF">CPF *</label>
                                <input type="text" value="@if(isset($pessoa->cpf)){{$pessoa->cpf}}@else{{old('cpf')}}@endif" name='cpf' placeholder="Insira um Cpf" class='form-control' id="cpf">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="RG">RG *</label>
                                <input type="text" value="@if(isset($pessoa->rg)){{$pessoa->rg}}@else{{old('rg')}}@endif" name='rg' placeholder="Insira um Rg" class='form-control' id="rg">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Telefone</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input name="telefone" value="@if(isset($pessoa->telefone)){{$pessoa->telefone}}@else{{old('telefone')}}@endif" type="text"  class="form-control" id="phone_with_ddd">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <div class="form-group col-md-6">
                                <label>Celular</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-mobile-phone"></i>
                                    </div>
                                    <input name="celular" type="text" value="@if(isset($pessoa->celular)){{$pessoa->celular}}@else{{old('celular')}}@endif" class="form-control" id="cel">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <div class="form-group col-md-6">
                                <label>Mensagem</label>
                                <textarea  class="form-control" name="mensagem" id="textos">@if(isset($pessoa->mensagem)){{$pessoa->mensagem}}@else{{old('mensagem')}}@endif</textarea>
                            </div>
                            <!-- /.form group -->

                            <div class="box-footer col-md-6">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                &nbsp;&nbsp;<button type="reset" class="btn">Limpar</button>
                                &nbsp;&nbsp;<a href="{{url('/painel/pessoas')}}" class="btn btn-info"><i class=''></i>Voltar</a>
                            </div>

                        </div>
                    </form>
                    <!-- /.box -->
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts-footer')
    <script src="{{url('/assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{url('/assets/js/masks.js')}}"></script>
@endsection