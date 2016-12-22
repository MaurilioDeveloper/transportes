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
        <li><a href="{{ route('listarFretes') }}"><i class="fa fa-plus-circle"></i> Cadastra Viagens</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

<!-- Retorna a Data do Servidor, convertendo-a em Brasileiro -->
<div style="display: none">
    {{ \Date::setLocale('pt-BR') }}
    {{ $data = \Date::now() }}
</div>

<!-- Main content -->
{{--<section class="content">--}}
{{--<div id="gritter-notice-wrapper" style="display: none"><div id="gritter-item-4" class="gritter-item-wrapper success-notice" role="alert"><div class="gritter-item"><a class="gritter-close" href="#" tabindex="1"><i class="en-cross"></i></a><i class="ec-trashcan gritter-icon"></i><div class="gritter-without-image"><span class="gritter-title">Sucesso !!!</span><p>Frete Cadastrado com Sucesso. </p></div><div style="clear:both"></div></div></div></div>--}}
<div class="row">
    <div class="col-md-12">

        <div class='box box-primary'>

            <div class="box-header with-border">
                <h3 class="box-title">Os campos com * são obrigatórios</h3>
            </div>

            <div class="box-body">
                {{--@include('painel.errors._errors_form')--}}
                <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>
                <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Frete Cadastrado com Sucesso</div>

                {{--@if(isset($frete->id) && $frete->id > 0)--}}
                    {{--{!! Form::model($frete, ['route' => ['updateFrete','frete' => $frete->id], 'class' => 'form', 'send' => 'updateFrete', 'name' => 'form', 'method' => 'PUT']) !!}--}}

                {{--@else--}}
                    {{--{!! Form::open(['route' => 'cadastrarFrete', 'class' => 'form', 'send' => 'cadastrar-frete', 'name' => 'form-frete']) !!}--}}
                {{--@endif--}}



            </div>
        </div>
    </div>
</div>

@section('scripts-footer')
    {{--<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{url('/assets/js/cadastros/cad-viagem.js')}}"></script>
    <script src="{{url('/assets/js/ischeck.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/maskMoney.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
@endsection

@endsection