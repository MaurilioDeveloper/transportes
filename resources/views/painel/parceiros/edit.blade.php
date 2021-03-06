@extends('painel.template.template')

@section('styles-head')
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/plugin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/loading.css')}}"/>
@endsection


@section('content')
<style>
    .ui-datepicker{
        z-index: 1050!important;
    }
</style>
@section('title')
    <h1>{{ $titulo }}: {{$parceiro->nome}}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('listarParceiros') }}"><i class="fa fa-briefcase"></i> Parceiros</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection



{{--<!----}}
<div class="modal fade bs-example-modal-lg5 in" id="cadastra-tipo-ocorrencia" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="modal-title" id="myModalLabel">Cadastrar Tipo Ocorrência</h3>
                </div>

                {{--{!! Form::open(['route' => 'postTipoOcorrencia', 'class' => 'form', 'name' => 'form-tipo-ocorrencia', 'send' => '/painel/parceiros/postTipoOcorrencia']) !!}--}}
                <!-- form start -->
                <div class="box-body">
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn-tipo" role="alert"></div>
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc-tipo" role="alert">Tipo de Ocorrência Cadastrada com Sucesso</div>

                    {!! Form::open(['route' => 'postTipoOcorrencia', 'class' => 'form', 'name' => 'form-tipo-ocorrencia', 'send' => '/painel/parceiros/postTipoOcorrencia']) !!}
                        <h4 class="box-title">Os campos com * são obrigatórios</h4>

                        <div class="form-group col-md-12">
                            {!! Form::label('nome', 'Tipo Ocorrência *') !!}
                            {!! Form::text('nome', null, ['class' => 'form-control', 'required' => 'true']) !!}
                        </div>

                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        <div style="float: right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            {!! Form::submit('Salvar', ['class' => 'btn btn-primary', 'id' => 'btn-tipo']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                {{--{!! Form::close() !!}--}}
            </div><!--box-primary-->
        </div><!--modal-content-->
    </div>  <!--modal-dialog-->
</div>




<div class="modal fade bs-example-modal-lg5 in" id="cadastra-ocorrencia" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div id="title-cad"><h3 class="modal-title" id="myModalLabel">Cadastrar Ocorrência</h3></div>
                    <h3 id="title-edit" class="modal-title" style="display: none">Editar Ocorrência</h3>
                </div>

                <!-- form start -->
                <div class="box-body">
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Ocorrência Cadastrada com Sucesso</div>

                    {{--<div id="postOcorrencia">--}}
                        {!! Form::open(['route' => 'postOcorrencia', 'class' => 'form-ocorrencia', 'name' => 'form-ocorrencia', 'send' => '/painel/parceiros/postOcorrencia', 'id' => 'ocorrencia-form']) !!}
{{--                        {!! Form::open(['route' => ['updateOcorrencia', $parceiro->id], 'class' => 'form-ocorrencia', 'name' => 'form-ocorrencia', 'send' => '/painel/parceiros/updateOcorrencia', 'id' => 'ocorrencia-form-update']) !!}--}}
                    {{--<form name="form-ocorrencia" class="form-ocorrencia" method="PUT" action="/painel/parceiros/updateOcorrencia/".{{$parceiro->id}} >--}}
                        {{--<input type="hidden" value="{!! csrf_token() !!}" />--}}
                    {{--</div>--}}

                    <h4 class="box-title">Os campos com * são obrigatórios</h4>
                    <div class="form-group col-md-12">
                        {!! Form::label('data', 'Data *') !!}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::input('text', 'data', null,  ['class' => 'form-control pull-right datapicker data-ocorrencia', 'id' => 'datapicker', 'required' => 'true', 'placeholder' => '__/__/____']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('id_tipo_ocorrencia', 'Tipo de Ocorrência *') !!}
                        {!! Form::select('id_tipo_ocorrencia',  array_merge([0 => '(Selecione)'], $tipo_ocorrencia), null, ['class' => 'form-control', 'required' => 'true', 'id' => 'tipo-ocorrencia']) !!}
                    </div>
                    {{--<div class="form-group col-md-12">--}}
                    {{--<div class=""><a href="#" class="btn btn-info" id="botao-tipo-ocorrencia"><i class="fa fa-plus"></i> Cadastrar Tipo de Ocorrências</a></div>--}}
                    {{--</div>--}}
                    <div class="form-group col-md-12">
                        <div style="display: none;">
                            {!! Form::input('text', 'id_usuario', auth()->user()->id, ['class' => '','style' => 'width:217px; background: #f0f0f0 !important; color: #aaa !important; border: #ccc;']) !!}
                        </div>
                        <div style="display: none;">
                            {!! Form::input('text', 'id_parceiro', $parceiro->id, ['class' => '','style' => 'width:217px; background: #f0f0f0 !important; color: #aaa !important; border: #ccc;']) !!}
                        </div>
                        {!! Form::label('usuario', 'Usuário Autor *') !!}
                        {!! Form::select('usuario', [auth()->user()->name], auth()->user()->name, ['class' => 'form-control id_usuario_ocorrencia', 'disabled' => 'true']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('descricao', 'Descrição') !!}
                        {!! Form::textarea('descricao', null, ['class' => 'form-control descricao_ocorrencia']) !!}
                    </div>

                    <div class="form-group col-md-12">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar
                            </button>
                            {!! Form::submit('Salvar', ['class' => 'btn btn-primary', 'id' => 'botao']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
                <script>
                    $("button#closeO.btn").click(function () {
                        $("#form-ocorrencia").hide();
                    });
                </script>

            </div><!--box-primary-->
        </div><!--modal-content-->
    </div>  <!--modal-dialog-->
</div>



<div style="display: none;" id="dialog-confirm" title="Deletar">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente excluir essa Ocorrência?</p>
</div>
{{--<!----}}

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class='box box-primary'>

                <div class="box-header with-border">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#parceiro" aria-controls="tipo-ocorrencia"
                                                                  role="tab" data-toggle="tab">Dados do Parceiro</a>
                        </li>
                        @if(isset($parceiro) && $parceiro->id > 0)
                        <li role="presentation"><a href="#lista-ocorrencia" aria-controls="home" role="tab"
                                                   data-toggle="tab">Ocorrências <span>({{count($ocorrencias)}})</span>
                            </a></li>
                        @endif
                    </ul>

                </div>
                <div class="box-body">

                    <div class="form-group col-md-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="lista-ocorrencia">
                                    <table class="table table-bordered" id="ocorrencia-table">
                                        <thead>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th>Usuário Autor</th>
                                        <th>Ações</th>
                                        </thead>
                                        <tbody id="tabela-ocorrencia">
                                        @forelse($ocorrencias as $ocorrencia)
                                            <tr class="warning">

                                                <td>{{ implode('/',array_reverse(explode('-', $ocorrencia->data))) }}</td>
                                                <td>{{ $ocorrencia->tipo }}</td>
                                                <td>{{ $ocorrencia->descricao }}</td>
                                                <td>{{ $ocorrencia->usuario }}</td>
                                                <td>
                                                    <a id-ocorrencia="{{$ocorrencia->id}}"  class="btn btn-primary btn-sm edit" data-toggle="modal" data-target="#cadastra-ocorrencia" onclick="openOcorrenciaEdit({{$ocorrencia->id}})"><i class="fa fa-edit"></i></a>
                                                    <a id-ocorrencia="{{$ocorrencia->id}}" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></a>
                                                </td>
                                                {{--</tr>--}}
                                                @empty
                                                    <tr class="warning">
                                                        <td colspan="7" style="text-align: center"> Nenhum Dado Cadastrado</td>
                                                    </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <hr style="border: 1px solid #ccc"/>
                                    <div style="display: inline;" class=""><a href="#" class="btn btn-info" data-toggle="modal" data-target="#cadastra-ocorrencia" id="cadastra-ocorrencia"><i class="fa fa-plus"></i> Cadastrar Ocorrências</a></div>
                                    <div style="display: inline;"  class=""><a href="#" class="btn btn-success" data-toggle="modal" data-target="#cadastra-tipo-ocorrencia" id="cadastra-tipo-ocorrencia"><i class="fa fa-gears"></i> Cadastrar Tipo Ocorrências</a></div>
                                </div>


                                <!--<div role="tabpanel" class="tab-pane" id="cad-ocorrencia">
                                    <!-- form start -->
                                    <!--<div class="box-body" id="form-ocorrencia">
                                        <h4 class="box-title">Os campos com * são obrigatórios</h4>

                                    <br/>
                                    <hr style="border: 1px solid #ccc"/>
                                </div>-->

                                <div role="tabpanel" class="tab-pane" id="tipo-ocorrencia">
                                    <!-- form start -->
                                    <div class="box-body">
                                        {{--<h4 class="box-title">Os campos com * são obrigatórios</h4>--}}
                                        {!! Form::open(['route' => 'postTipoOcorrencia', 'class' => 'form']) !!}

                                        <div class="form-group col-md-12">
                                            {!! Form::label('nome', 'Tipo Ocorrência *') !!}
                                            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-default">Fechar</button>
                                            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                    <br/>
                                    <hr style="border: 1px solid #ccc"/>
                                </div>

                                <div role="tabpanel" class="tab-pane active" id="parceiro">
                                    {{--<div class="box-body">--}}
                                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>
                                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Parceiro Alterado com Sucesso</div>


                                    {!! Form::model($parceiro, ['route' => ['parceiros.update','client' => $parceiro->id], 'name' => 'update-parceiro', 'class' => 'form-parceiro-update', 'method' => 'PUT', 'send' => '/painel/parceiros/'.$parceiro->id]) !!}

                                    <h3 class="" style="font-size: 19px">Os campos com * são obrigatórios</h3>
                                    <div class="form-group col-md-12"><h3
                                                class="box-title">{{$pessoa == \App\Models\Parceiro::PESSOA_JURIDICA ? 'Pessoa Júridica': 'Pessoa Física'}}</h3>
                                    </div>

                                    {{--@include('painel.errors._errors_form')--}}



                                    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                                    @include('painel.parceiros._form')

                                    <div class="form-group col-md-6">
                                        <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> Salvar</button>
                                        <a class="btn btn-info" href="{{route('parceiros.index')}}">Voltar</a>
                                        <button type="reset" class="btn">Limpar</button>
                                    </div>
                                    {!! Form::close() !!}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts-footer')
    <script src="{{url('/assets/js/vendor/jquery.blockUI.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/cadastros/cad-parceiro.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/cadastros/cad-ocorrencia.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/cadastros/cad-tipo-ocorrencia.js')}}"></script>
@endsection
@endsection