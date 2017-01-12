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
        <li><a href="{{ route('listarFretes') }}"><i class="fa fa-briefcase"></i> Fretes</a></li>
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
                <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">@if(isset($frete))Frete Alterado com Sucesso @else Frete Cadastrado com Sucesso @endif</div>

                @if(isset($frete->id) && $frete->id > 0)
                    {!! Form::model($frete, ['route' => ['updateFrete','frete' => $frete->id], 'class' => 'form', 'send' => '/painel/fretes/update/'.$frete->id, 'name' => 'form-frete', 'files' => 'true', 'method' => 'PUT']) !!}
                    <input type="hidden" id="frete-id-dados" value="{{$frete->id}}" />
                @else
                    {!! Form::open(['route' => 'cadastrarFrete', 'class' => 'form', 'send' => 'cadastrar-frete', 'name' => 'form-frete', 'files' => 'true']) !!}
                @endif


                <fieldset class="callout column small-12">
                    <legend><b>Parceiro - Datas</b></legend>
                    <div class="form-group col-md-9">
                        <input type="hidden"  />
                        <label for="Nome">Parceiro *</label>
{{--                        {!! Form::select('id_parceiro', [], null, ['class' => 'form-control select2_frete', 'required' => 'true', 'id' => 'frete']) !!}--}}
                        <select class="form-control select2_frete" id="frete" name="id_parceiro">
                            @if(isset($frete->id_parceiro))
                                <option value="{{$frete->id_parceiro}}" selected>{{$freteParceiroNome}}</option>
                            @else
                                @if(isset($idParceiro))
                                    <option value="{{$idParceiro}}" selected>{{$nomeParceiro}}</option>
                                @else
                                    <option value="0" selected>Selecione um parceiro</option>
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>
                            <hr>
                        </label>
                        <a href="{{route('adicionarParceiro')}}" style="text-decoration: none"
                           class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Cadastrar Novo Parceiro</a>
                    </div>
                <div id="dados1" style="@if(!isset($idParceiro) && !isset($frete->id_parceiro))display: none; @endif">

                        {!! Form::hidden('id_usuario', auth()->user()->id, ['class' => '','style' => 'width:217px; background: #f0f0f0 !important; color: #aaa !important; border: #ccc;']) !!}
                        <div class="form-group col-md-4">
                            <label>Data Atual</label>
                            <input required="" name='data_hoje' type="text" placeholder="dd/mm/yyyy"
                                   class="form-control datapicker" value="{{ $data_hoje or $data->format('d/m/Y') }}"/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Data Prevista Inicio *</label>
                            <input required="" name='data_inicio' type="text" placeholder="dd/mm/yyyy"
                                   class="form-control datapicker" value="{{$data_inicio or old('data_inicio')}}"/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Data Prevista Fim</label>
                            <input required="" name='data_fim' type="text" placeholder="dd/mm/yyyy"
                                   class="form-control datapicker" value="{{$data_fim or old('data_fim')}}"/>
                        </div>
                    </div>
                </fieldset>

                <div id="dados2" style="@if(!isset($idParceiro) && !isset($frete->id_parceiro))display: none; @endif">

                <fieldset class="callout column small-12">
                    <legend><b>Origem - Destino</b></legend>


                    <div class="form-group col-md-6">
                        {!! Form::label('cidade', 'Cidade Origem *') !!}
                        <select name="id_cidade_origem" class="form-control" id="cidade_origem" required>
                            <option value="0">Selecione uma Cidade</option>
                            {{--                            {{$estados}}--}}
                            @if(isset($cidades))
                                @foreach($cidades as $key => $value)
                                    @if(isset($frete->id_cidade_origem) && $key === $frete->id_cidade_origem)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        {{--{{old('status')}}--}}
                                    @else
                                        <option value="{{$key}}" {{old('id_cidade_origem') == $value ? 'selected="selected"' : ''}}>{{$value}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>


                    {{--</fieldset>--}}

                    {{--<fieldset class="callout column small-12">--}}
                    {{--<legend><b>Destino</b></legend>--}}

                    <div class="form-group col-md-6">
                        {!! Form::label('cidade', 'Cidade Destino *') !!}
                        <select name="id_cidade_destino" class="form-control" id="cidade_destino" required>
                            <option value="0">Selecione uma Cidade</option>
                            {{--                            {{$estados}}--}}
                            @if(isset($cidades))
                                @foreach($cidades as $key => $value)
                                    {{--{{$value}}--}}
                                    @if(isset($frete->id_cidade_destino) && $key === $frete->id_cidade_destino)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        {{--{{old('status')}}--}}
                                    @else
                                        <option value="{{$key}}" {{old('cidade_destino') == $value ? 'selected="selected"' : ''}}>{{$value}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        {{--{!! Form::text('cidade_destino', null, ['class' => 'form-control', 'placeholder' => 'Cidade']) !!}--}}
                        {{--<input required type="text" name="cidade_destino" class="form-control" placeholder="Cidade" value="@if(isset($viagem->cidade_destino)){{$viagem->cidade_destino}}@else{{old('cidade_destino')}}@endif" />--}}
                    </div>

                </fieldset>

                <fieldset class="callout column small-12">
                    <legend><b>Descrição do Item</b></legend>
                    {{--<hr style="border: 1px solid #ccc"/>--}}

                    <div class="form-group col-md-6">
                        {!! Form::label('tipo', 'Tipo *') !!}
{{--                        {!! Form::text('tipo', null, ['class' => 'form-control', 'placeholder' => 'Carro, Barco, etc']) !!}--}}
                        <input type="text" name="tipo" class="form-control" placeholder="Carro, Barco, etc.." required="true" value="@if(isset($frete->tipo)){{$frete->tipo}}@else{{old('tipo')}}@endif" />
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('valor', 'Valor *') !!}
                        {{--{!! Form::text('valor_item', null, ['class' => 'form-control', 'placeholder' => 'R$00,00']) !!}--}}
                        <input type="text" name="valor_item" class="form-control moeda" data-prefix="R$" placeholder="Valor" required value="@if(isset($frete->valor_item)){{$frete->valor_item}}@else{{old('valor_item')}}@endif" />
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('identificacao', 'Placa') !!}
                        {{--{!! Form::text('identificacao', null, ['class' => 'form-control', 'placeholder' => 'Identificação']) !!}--}}
                        <input type="text" name="identificacao" class="form-control placa" placeholder="Placa" value="@if(isset($frete->identificacao)){{$frete->identificacao}}@else{{old('identificacao')}}@endif" />
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('chassi', 'Chassi') !!}
                        {{--{!! Form::text('identificacao', null, ['class' => 'form-control', 'placeholder' => 'Identificação']) !!}--}}
                        <input type="text" name="chassi" class="form-control" placeholder="Chassi" value="@if(isset($frete->chassi)){{$frete->chassi}}@else{{old('chassi')}}@endif" />
                    </div>

                    {{--<div class="form-group col-md-6">--}}
{{--                        {!! Form::label('identificacao', 'Identificação') !!}--}}
                        {{--{!! Form::text('identificacao', null, ['class' => 'form-control', 'placeholder' => 'Identificação']) !!}--}}
                        {{--<input type="text" name="identificacao" class="form-control" placeholder="Identificação" value="@if(isset($frete->identificacao)){{$frete->identificacao}}@else{{old('identificacao')}}@endif" />--}}
                    {{--</div>--}}

                    <div class="form-group col-md-6">
                        {!! Form::label('cor', 'Cor') !!}
                        {{--{!! Form::text('cor', null, ['class' => 'form-control', 'placeholder' => 'Azul']) !!}--}}
                        <input type="text" name="cor" class="form-control" placeholder="Cor" value="@if(isset($frete->cor)){{$frete->cor}}@else{{old('cor')}}@endif" />
                    </div>
                </fieldset>


                <fieldset class="callout column small-12">
                    <legend><b>Status - Coleta - Entrega</b></legend>

                    {{--<hr style="border: 1px solid #ccc"/>--}}

                    @if(isset($frete->id) && $frete->id > 0)
                        <div class="form-group col-md-9">
                    @else
                        <div class="form-group col-md-12">
                    @endif
                        {!! Form::label('status', 'Status *') !!}
                        <select id="status-select" class="form-control" name="status" required>
                            <option value="0">Selecione um status</option>
                            @foreach(\App\Frete::STATUS as $key => $value)
                            @if(isset($frete->status) && $value === $frete->status)
                                <option  selected>{{$frete->status}}</option>
                            @else
                                <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @if(isset($frete->id) && $frete->id > 0)
                        <div class="form-group col-md-3">
                            <label><hr/></label>
                            <a style="text-decoration: none" class="btn btn-info" onclick="verHistorico()"><i class="fa fa-history"></i> Ver Histórico <span class="badge badge-primary">@if(isset($historicoFretes)){{count($historicoFretes)}}@endif</span></a>
                        </div>
                    @endif
                    <div class="form-group col-md-3">
                        <label class="columns" for="unit-yes-no-coleta">
                            Tem Coleta?
                        </label>
                    </div>
                    <div class="form-group col-md-9">
                        <label class="" for="unit-yes-no-entrega">
                            Tem Entrega?
                        </label>
                    </div>
                    @if(isset($iscoleta) && $iscoleta === "on")
                        <input type="hidden" value="{{$iscoleta}}" id="iscoletaON" />
                        <div class="form-group col-md-3">
                            <div class="switch large">
                                <input class="switch-input ativo" id="unit-yes-no5" value="{{$iscoleta}}" name="iscoleta" type="checkbox">
                                <label class="switch-paddle" for="unit-yes-no5">
                                    <span class="switch-active" aria-hidden="true">Sim</span>
                                    <span class="switch-inactive" aria-hidden="true">Não</span>
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="form-group col-md-3">
                            <div class="switch large">
                                <input class="switch-input" id="unit-yes-no5" name="iscoleta" type="checkbox">
                                <label class="switch-paddle" for="unit-yes-no5">
                                    <span class="switch-active" aria-hidden="true">Sim</span>
                                    <span class="switch-inactive" aria-hidden="true">Não</span>
                                </label>
                            </div>
                        </div>
                    @endif


                    @if(isset($isentrega) && $isentrega === "on")
                        <input type="hidden" value="{{$isentrega}}" id="isentregaON" />
                        <div class="form-group col-md-9">
                            <div class="switch large">
                                <input class="switch-input ativo" id="unit-yes-no4" value="{{$isentrega}}" name="isentrega" type="checkbox">
                                <label class="switch-paddle" id="colet" for="unit-yes-no4">
                                    <span class="switch-active" aria-hidden="true">Sim</span>
                                    <span class="switch-inactive" aria-hidden="true">Não</span>
                                </label>
                            </div>
                        </div>
                    @else
                    <div class="form-group col-md-9">
                        <div class="switch large">
                            <input class="switch-input" id="unit-yes-no4" name="isentrega" type="checkbox">
                            <label class="switch-paddle" id="colet" for="unit-yes-no4">
                                <span class="switch-active" aria-hidden="true">Sim</span>
                                <span class="switch-inactive" aria-hidden="true">Não</span>
                            </label>
                        </div>
                    </div>
                    @endif


                    <div id="coletor" style="display: none;">
                        <div class="form-group col-md-6">
                            <label for="Nome">Coletor </label>
{{--                            {!! Form::select('id_parceiro_coletor', [], null, ['class' => 'form-control select2_ce', 'id' => 'id_coletor']) !!}--}}
                            <select name="id_parceiro_coletor" class="form-control select2_ce" id="id_coletor">
                                @if(isset($frete->id_parceiro_coletor))
                                    <option value="{{$frete->id_parceiro_coletor}}" selected>{{$freteParceiroColetorNome}}</option>
                                @else
                                    <option value="0">Selecione um Coletor</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Nome">Valor Coleta </label>
                            {{--{!! Form::text('valor_coleta', $frete->valor_coleta or old('valor_coleta'), ['class' => 'form-control moeda', 'data-prefix' => 'R$', 'placeholder' => 'R$00,00']) !!}--}}
                            <input name="valor_coleta" type="text" value="@if(isset($frete->valor_coleta)){{$frete->valor_coleta}}@else{{old('valor_coleta')}}@endif" class="form-control moeda" data-prefix="R$" placeholder="Valor" />
                        </div>
                    </div>
                    <div id="entregador" style="display: none;">

                        <div class="form-group col-md-6">
                            <label for="Nome">Entregador </label>

                            <select name="id_parceiro_entregador" class="form-control select2_ce" id="id_entregador">
                                @if(isset($frete->id_parceiro_entregador))
                                    <option value="{{$frete->id_parceiro_entregador}}" selected>{{$freteParceiroEntregadorNome}}</option>
                                @else
                                    <option value="0">Selecione um Entregador</option>
                                @endif
                            </select>
{{--                            {!! Form::select('id_parceiro_entregador', [], null, ['class' => 'form-control select2_ce', 'id' => 'id_entrega']) !!}--}}
                            {{--<select class="form-control select2_ce"></select>--}}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="valor_entrega">Valor Entrega </label>
                            {{--{!! Form::text('valor_entrega', $frete->valor_entrega or old('valor_entrega'), ['class' => 'form-control moeda', 'data-prefix' => 'R$', 'placeholder' => 'R$00,00']) !!}--}}
                            <input type="text" name="valor_entrega" class="form-control moeda" data-prefix="R$" placeholder="Valor" value="@if(isset($frete->valor_entrega)){{$frete->valor_entrega}}@else{{old('valor_entrega')}}@endif" />
                        </div>

                    </div>

                </fieldset>
                <script>

                </script>
                <fieldset class="callout column small-12">
                    <legend><b>Valor Total - Informações</b></legend>

                    <div class="form-group col-md-6">
                        {!! Form::label('valor_total', 'Valor Total') !!}
                        {!! Form::text('valor_total', null, ['class' => 'form-control moeda', 'data-prefix' => 'R$', 'placeholder' => 'R$00,00']) !!}
                        {{--{!! Form::text('valor_total2', null, ['class' => 'form-control moeda', 'data-prefix' => 'R$', 'placeholder' => 'R$00,00']) !!}--}}
                    </div>

                    @if(isset($frete->id) && $frete->id > 0)
                        <div class="form-group col-md-6">
                            {!! Form::label('image', 'Ficha Checklist') !!}
                            @if(isset($frete->image) && ($frete->image) != null)
                            <div class="form-group"><a target="_blank" href="{{url('/fretes_imagens/'.$frete->image)}}"><img width="350px" height="200px" style="border: 1px solid #ccc; border-radius: 10px" src="{{url('/fretes_imagens/'.$frete->image)}}" /></a></div>
                            {!! Form::file('image') !!}
                            @else
                                {!! Form::file('image') !!}
                            @endif
                        </div>
                    @else
                        <div class="form-group col-md-6">
                            {!! Form::label('image', 'Ficha Checklist') !!}
                            {!! Form::file('image', null, ['accept'=>'images/*']) !!}
                        </div>
                    @endif

                    <div class="form-group col-md-12">
                        {!! Form::label('informacoes_complementares', 'Informações Complementares') !!}
                        {!! Form::textarea('informacoes_complementares', null, ['class' => 'form-control']) !!}
                    </div>
                </fieldset>


                <div class="form-group col-md-12" style="display: none;">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Coleta</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-plus"></i>
                                </button>
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="id_parceiro_coletor">Coletor</label>
{{--                                {!! Form::select('id_parceiro_coletor', [], null, ['class' => 'form-control', 'id' => 'coletor']) !!}--}}
                            </div>
                            <div class="form-group col-md-6">
                                {{--<label for="valor_total">Valor</label>--}}
{{--                                {!! Form::text('valor_total', null, ['class' => 'form-control']) !!}--}}
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>

                <!-- Tem Entrega -->


                <div class="form-group col-md-6">
                    <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> @if(isset($frete->id) && $frete->id > 0) Salvar @else Cadastrar @endif</button>
                    {{--{!! Form::submit('Cadastrar', ['class' => 'btn btn-primary', 'id' => 'botao']) !!}--}}
                    <a class="btn btn-info" href="{{route('listarFretes')}}">Voltar</a>
                    <button type="reset" class="btn">Limpar</button>
                </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg5 in" id="parceiros" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="modal-title" id="myModalLabel">Dados do Parceiro</h3>
                </div>
            </div>
            <div class="box box-body">
                {!! Form::hidden('pessoa', null, ['class' => 'pessoa']) !!}
                {!! Form::hidden('sexo', null, ['class' => 'sexo']) !!}

                <div class="form-group col-md-6">
                    <label for="Nome">Nome</label>
                    {!! Form::text('nome', null, ['class' => 'form-control nome_parceiro', 'disabled' => 'true']) !!}
                </div>

                <div class="cnpj" style="display: none">
                    <div class="form-group col-md-6">
                        <label for="cnpj">CNPJ*</label>
                        {{--<script>$('.pessoa').val();</script>--}}
                        {{--@if($fretePessoa === "juridica")--}}
                            {!! Form::text('documento', null, ['class' => 'form-control documento', 'disabled' => 'true', 'id' => 'cnpj']) !!}

                        {{--@endif--}}
                    </div>
                </div>

                <div class="cpf"  style="display: none">
                    <div class="form-group col-md-6">
                            <label for="cnpj">CPF*</label>
                            {!! Form::text('documento', null, ['class' => 'form-control documento', 'disabled' => 'true', 'id' => 'cpf']) !!}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('email', 'E-mail *') !!}
                    {!! Form::email('email', null, ['class' => 'form-control email', 'disabled' => 'true']) !!}
                </div>


                <div class="form-group col-md-6">
                    {!! Form::label('telefone', 'Telefone *') !!}
                    {!! Form::text('telefone', null, ['class' => 'form-control telefone', 'disabled' => 'true', 'id' => 'phone']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('estado', 'Estado *') !!}
                    {!! Form::text('estado', null, ['class' => 'form-control estado', 'disabled' => 'true', 'id' => 'state']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('cidade', 'Cidade *') !!}
                    {!! Form::text('cidade', null, ['class' => 'form-control cidade', 'disabled' => 'true']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('bairro', 'Bairro') !!}
                    {!! Form::text('bairro', null, ['class' => 'form-control bairro', 'disabled' => 'true']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('endereco', 'Endereco *') !!}
                    {!! Form::text('endereco', null, ['class' => 'form-control endereco', 'disabled' => 'true']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('cep', 'CEP') !!}
                    {!! Form::text('cep', null, ['class' => 'form-control cep', 'disabled' => 'true', 'id' => 'cep']) !!}
                </div>


                <div class="juridica" style="display: none">
                    <div class="form-group col-md-6">
                        {!! Form::label('fantasia', 'Fantasia *') !!}
                        {!! Form::text('fantasia', null, ['class' => 'form-control fantasia', 'disabled' => 'true']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('inscricao_estadual', 'Inscrição Estadual *') !!}
                        {!! Form::text('inscricao_estadual', null, ['class' => 'form-control inscricao_estadual', 'disabled' => 'true']) !!}
                    </div>
                </div>

                <div class="fisica" style="display: none">
                    <div class="form-group col-md-6">
                        {!! Form::label('estado_civil', 'Estado Civil *') !!}
                        {!! Form::select('estado_civil', array_merge([0 => 'Selecione'],\App\Parceiro::ESTADOS_CIVIS), null, ['class' => 'form-control estado_civil', 'disabled' => 'true']) !!}
                    </div>

                    <div class="form-group col-md-6">

                        {!! Form::label('data_nasc', 'Data Nascimento *') !!}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::date('data_nasc', null , ['class' => 'form-control pull-right data_nasc', 'disabled' => 'true', 'id' => '']) !!}
                        </div>

                    </div>




                @if(isset($sexo) && $sexo == 'm')
                    {{--<div style="display: none" class="masculino">--}}
                        <div class="form-group col-md-3" style="margin-top: 30px">
                            <label>
                                <div class="iradio_flat-green hover" aria-checked="false"
                                     aria-disabled="false">{!! Form::radio('sexo', 'm', true, ['class' => 'flat-red', 'disabled' => 'true']) !!}
                                    <ins class="iCheck-helper"></ins>
                                </div>
                                Masculino
                            </label>
                        </div>

                        <div class="form-group col-md-3" style="margin-top: 30px">
                            <label>
                                <div class="iradio_flat-green hover" aria-checked="false"
                                     aria-disabled="false">{!! Form::radio('sexo', 'f', false, ['class' => 'flat-red', 'disabled' => 'true']) !!}
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                Feminino
                            </label>
                        </div>
                    {{--</div>--}}
                @else
                        <div class="form-group col-md-3" style="margin-top: 30px">
                            <label>
                                <div class="iradio_flat-green hover" aria-checked="false"
                                     aria-disabled="false">{!! Form::radio('sexo', 'm', false, ['class' => 'flat-red', 'disabled' => 'true']) !!}
                                    <ins class="iCheck-helper"></ins>
                                </div>
                                Masculino
                            </label>
                        </div>

                        <div class="form-group col-md-3" style="margin-top: 30px">
                            <label>
                                <div class="iradio_flat-green hover" aria-checked="false"
                                     aria-disabled="false">{!! Form::radio('sexo', 'f', true, ['class' => 'flat-red', 'disabled' => 'true']) !!}
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                Feminino
                            </label>
                        </div>
                @endif


                </div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-success edit" style="float: left;" target="_blank"><i class="fa fa-edit"></i> Alterar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                {{--{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}--}}
            </div>
            {{--{!! Form::close() !!}--}}
        </div><!--box-primary-->
    </div><!--modal-content-->
</div>  <!--modal-dialog-->
</div>



<!-- Modal -->
<div class="modal fade" id="lista-historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #75b9e6; color: #000; font-weight: bold">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 style="text-align: center;" class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Histórico do Frete (Mudança de STATUS)</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <tr style="background: #2e6da4; color: white">
                        <td>Data</td>
                        <td>Status</td>
                        <td>Usuário Logado</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($historicoFretes))
                        @forelse($historicoFretes as $historico)
                            <tr>
                                <td>{{ date('d/m/Y H:i:s', strtotime(implode('/', explode('-', $historico->created_at)))) }}</td>
                                <td>{{$historico->status}}</td>
                                <td>{{$historico->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhum histórico salvo</td>
                            </tr>
                        @endforelse
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

{{--</section>--}}

<!--
<div class="modal fade bs-example-modal-lg5 in" id="parceiro" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="modal-title" id="myModalLabel">Cadastrar Parceiro</h3>
                </div>

                <!-- form start -->
<!--            <div class="box-body">
                    <h4 class="box-title">Os campos com * são obrigatórios</h4>
                    {{--{!! Form::open(['route' => 'postParceiro', 'class' => 'form']) !!}--}}
        <div class="form-group col-md-12">

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        {{--{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}--}}
        </div>
        {{--{!! Form::close() !!}--}}
        </div><!--box-primary-->
{{--</div><!--modal-content-->--}}
{{--</div>  <!--modal-dialog-->--}}
{{--</div>--}}

@section('scripts-footer')
    {{--<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{url('/assets/js/cadastros/cad-frete.js')}}"></script>
    <script src="{{url('/assets/js/ischeck.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/maskMoney.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
@endsection

@endsection