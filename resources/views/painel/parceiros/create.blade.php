@extends('painel.template.template')

@section('styles-head')
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/plugin.css')}}"/>
@endsection



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

{{--<div id="gritter-notice-wrapper" style="display: none"><div id="gritter-item-4" class="gritter-item-wrapper success-notice" role="alert"><div class="gritter-item"><a class="gritter-close" href="#" tabindex="1"><i class="en-cross"></i></a><i class="ec-trashcan gritter-icon"></i><div class="gritter-without-image"><span class="gritter-title">Sucesso !!!</span><p>Parceiro Cadastrado com Sucesso. </p></div><div style="clear:both"></div></div></div></div>--}}
{{--<button id="success-notice" type="button" class="btn btn-success mr15 mb15">Success notice</button>--}}
<!-- Main content -->
    {{--<section class="content">--}}
        <div class="row">
            <div class="col-md-12">

                <div class='box box-primary'>

                <div class="box-header with-border">
                        <h3 class="box-title">Os campos com * são obrigatórios</h3>
                        {{--<div class="pull-right"><a href="#" class="btn btn-info" data-toggle="modal" data-target="#tipoOcorrencia"><i class="fa fa-gear"></i> Tipo de Ocorrências</a></div>--}}
                        {{--<div class="pull-right" style="margin-right: 10px"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#ocorrencia"><i class="fa fa-gear"></i> Ocorrências</a></div>--}}
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
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
    <!-- Core plugins ( not remove ever) -->
    <script type="text/javascript" src="{{url('/assets/js/libs/modernizr.custom.js')}}"></script>
    <!-- Handle responsive view functions -->
    <script type="text/javascript" src="{{url('/assets/js/jRespond.min.js')}}"></script>
    <script type= src="{{url('/assets/js/jquery.sprFlat.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/notification.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/plugins/ui/notify/jquery.gritter.js')}}"></script>
@endsection
@endsection