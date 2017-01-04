@extends('painel.template.template')

@section('styles-head')
    {{--<link type="text/css" href="css/custom-theme/jquery-ui-1.8.20.custom.css" rel="stylesheet" />--}}
    <link href="{{url('/assets/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{url('/assets/css/app.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/plugin.css')}}"/>
@endsection

@section('content')

@section('title')
    <h1>{{ $titulo }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('listarFretes') }}"><i class="fa fa-globe"></i> Cidades - Estados</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection


<!-- Main content -->
{{--<section class="content">--}}
{{--<div id="gritter-notice-wrapper" style="display: none"><div id="gritter-item-4" class="gritter-item-wrapper success-notice" role="alert"><div class="gritter-item"><a class="gritter-close" href="#" tabindex="1"><i class="en-cross"></i></a><i class="ec-trashcan gritter-icon"></i><div class="gritter-without-image"><span class="gritter-title">Sucesso !!!</span><p>Frete Cadastrado com Sucesso. </p></div><div style="clear:both"></div></div></div></div>--}}
<div class="row">
    <div class="col-md-6">

        <div class='box box-primary'>

            <div class="box-header with-border">
                <h3 class="box-title">Os campos com * são obrigatórios</h3>
            </div>

            <div class="box-body">
                <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>

                @if(isset($cidadesEstados->id) && $cidadesEstados->id > 0)
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Cidade Alterada com Sucesso</div>
                    {!! Form::model($cidadesEstados, ['route' => ['updateCidadesEstados','cidadesEstados' => $cidadesEstados->id], 'class' => 'form', 'send' => '/painel/cidades-estados/update/'.$cidadesEstados->id, 'name' => 'form-cidades-estados', 'method' => 'PUT']) !!}
{{--                    <input type="hidden" id="edicao" value="{{$viagem->id}}" />--}}

                @else
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Cidade Cadastrada com Sucesso</div>
                    {!! Form::open(['route' => 'cadastrarCidadesEstados', 'class' => 'form', 'send' => 'cadastrar-CE', 'name' => 'form-cidades-estados']) !!}
                @endif

                    <div class="form-group col-md-6">
                    {!! Form::label('cidade', 'Cidade *') !!}
                    {!! Form::text('cidade', null, ['class' => 'form-control', 'id' => 'cidade']) !!}
                </div>


                <div class="form-group col-md-6">
                    {!! Form::label('estado', 'Estado') !!}
                    {!! Form::text('estado', null, ['class' => 'form-control', 'id' => 'state', 'maxlength' => '2', 'style' => 'text-transform: UPPERCASE']) !!}
                </div>

                <div class="form-group col-md-12">
                    {{--<hr style="border: 1px solid #3c8dbc"/>--}}
                    <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> @if(isset($cidadesEstados->id) && $cidadesEstados->id > 0) Salvar @else Cadastrar @endif</button>
                    {{--<button type="submit" class="btn btn-primary">Cadastrar</button>--}}
                    <a class="btn btn-info" href="{{route('listaCidadesEstados')}}">Voltar</a>
                    <button type="reset" class="btn">Limpar</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>


@section('scripts-footer')
    <script src="{{url('/assets/js/cadastros/cad-cidades-estados.js')}}"></script>
@endsection

@endsection