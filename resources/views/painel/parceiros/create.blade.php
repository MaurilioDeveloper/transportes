@extends('painel.template.template')

@section('styles-head')
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/plugin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/loading.css')}}"/>
@endsection


@section('breadcrumb')
    <h1>{{ $titulo }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('parceiros.index') }}"><i class="fa fa-briefcase"></i> Parceiros</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

@section('content')


<div id="gritter-notice-wrapper" style="display: none"><div id="gritter-item-4" class="gritter-item-wrapper success-notice" role="alert"><div class="gritter-item"><a class="gritter-close" href="#" tabindex="1"><i class="en-cross"></i></a><i class="ec-trashcan gritter-icon"></i><div class="gritter-without-image"><span class="gritter-title">Sucesso !!!</span><p>Parceiro Cadastrado com Sucesso. </p></div><div style="clear:both"></div></div></div></div>
<div class="overlay-loading" style="display: none;">
<span style="
     font-size: 30px;
     font-family: cursive;
     position: absolute;
     margin-top: 385px;
     margin-left: -85px">Carregando...</span></div>
{{--<button id="success-notice" type="button" onclick="$('#gritter-notice-wrapper').show()"  class="btn btn-success mr15 mb15">Success notice</button>--}}
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
                        {{--@include('painel.errors._errors_form')--}}
                        <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>
                        <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Parceiro Cadastrado com Sucesso</div>

                        @include('painel.errors._errors_form')
                        {!! Form::open(['route' => 'parceiros.store', 'class' => 'form', 'id' => 'meuForm', 'name' => 'cad-parceiro', 'send' => '/painel/parceiros']) !!}
{{--                        <form class="form" action="{{route('parceiros.store')}}">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                        @include('painel.parceiros._form')

                        <div class="form-group col-md-6">
                            <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> Cadastrar</button>
                            {{--<button type="submit" class="btn btn-primary">Cadastrar</button>--}}
                            <a class="btn btn-info" href="{{route('parceiros.index')}}">Voltar</a>
                            <button type="reset" class="btn">Limpar</button>
                        </div>
                        </form>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    {{--</section>--}}



@section('scripts-footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/maskMoney.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/vendor/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/cadastros/cad-parceiro.js')}}"></script>
    {{--<script src="{{url('/assets/plugins/core/slimscroll/jquery.slimscroll.min.js')}}"></script>--}}
{{--    <script src="{{url('/assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js')}}"></script>--}}
{{--    <script src="{{url('/assets/plugins/forms/tinymce/tinymce.min.js')}}"></script>--}}
{{--    <script src="{{url('/assets/plugins/forms/tags/jquery.tagsinput.min.js')}}"></script>--}}
    <!-- Core plugins ( not remove ever) -->
    {{--<script type="text  /javascript" src="{{url('/assets/js/vendor/modernizr.custom.js')}}"></script>--}}
    <!-- Handle responsive view functions -->
    {{--<script type="text/javascript" src="{{url('/assets/js/jRespond.min.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{url('/assets/plugins/ui/notify/jquery.gritter.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/assets/plugins/misc/countTo/jquery.countTo.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/assets/js/jquery.sprFlat.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{url('/assets/js/notification.js')}}"></script>--}}
@endsection
@endsection