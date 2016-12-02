@extends('painel.template.template')

@section('content')

@section('title')
    <h1>{{ $titulo }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('parceiros.index') }}"><i class="fa fa-briefcase"></i> Parceiros</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

<!-- Main content -->
    {{--<section class="content">--}}
        <div class="row">
            <div class="col-md-12">

                <div class='box box-primary'>

                <div class="box-header with-border">
                        <h3 class="box-title">Os campos com * são obrigatórios</h3>
                        <div class="pull-right"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-gear"></i> Ocorrências</a></div>
                </div>

                    <div class="box-body">
                        <h4>{{$pessoa == \App\Parceiro::PESSOA_JURIDICA ? 'Pessoa Júridica': 'Pessoa Física'}}</h4>
                        @include('painel.errors._errors_form')
                        {!! Form::open(['route' => 'parceiros.store', 'class' => 'form']) !!}

                        @include('painel.parceiros._form')

                        <div class="form-group col-md-6">
                            {!! Form::submit('Cadastrar', ['class' => 'btn btn-primary']) !!}
                            <a class="btn btn-info" href="{{route('parceiros.index')}}">Voltar</a>
                            <button type="reset" class="btn">Limpar</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    {{--</section>--}}

@section('scripts-footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
@endsection
@endsection
{{--
<section class="content-header">
@if ( isset($parceiro->id) )
    <h1>EDIÇÃO DO USUÁRIO</h1>
@else
    <h1>CADASTRO DE USUÁRIO</h1>
@endif

<ol class="breadcrumb">
    <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
    @if ( isset($parceiro->id) )
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
            @if ( isset($parceiro->id) )
                <form name='form' method='post' action='/m1-transportes/public/painel/parceiros/{{$parceiro->id}}'>
                    <input name="_method" value="PUT" type="hidden">
                    @else
                        <form name='form' method='post' action='/m1-transportes/public/painel/parceiros'>
                            @endif
                            {{ csrf_field() }}

                            <div class="box-body">
                                <div class="form-group col-md-6">
                                    {{--<label for="Nome">Nome *</label>--}}
{{--<input type="text" value="@if(isset($parceiro->name)){{$parceiro->name}}@else{{old('name')}}@endif" name='name' placeholder="Insira o Nome" class='form-control'>--}}
{{--</div>--}}
{{--<div class="form-group col-md-6">--}}
{{--<label for="exampleInputEmail">E-mail *</label>--}}
{{--<input type="text" value="@if(isset($parceiro->email)){{$parceiro->email}}@else{{old('email')}}@endif" name='email' placeholder="Insira um Email" class='form-control'>--}}
{{--</div>--}}
{{--<div class="form-group  col-md-6">--}}
{{--<label for="Senha">Senha *</label>--}}
{{--<input type="password" value="{{old('password')}}" name='password' placeholder="Insira uma Senha" class='form-control'>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="box-footer col-md-6">--}}
{{--<button type="submit" class="btn btn-primary">Salvar</button>&nbsp;&nbsp;<button type="reset" class="btn">Limpar</button>--}}
{{--</div>--}}
{{--</form>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}