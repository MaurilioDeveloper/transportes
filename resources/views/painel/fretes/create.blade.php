@extends('painel.template.template')

@section('styles-head')
    {{--<link type="text/css" href="css/custom-theme/jquery-ui-1.8.20.custom.css" rel="stylesheet" />--}}
    <link href="{{url('/assets/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{url('/assets/css/app.css')}}" rel="stylesheet"/>
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

<!-- Retorna a Data do Servidor, convertendo-a em Brasileiro -->
<div style="display: none">
    {{ \Date::setLocale('pt-BR') }}
    {{ $data = \Date::now() }}
</div>

<!-- Main content -->
{{--<section class="content">--}}
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
                {!! Form::open(['route' => 'cadastrarFrete', 'class' => 'form', 'send' => 'cadastrar-frete', 'name' => 'form-frete']) !!}


                <fieldset class="callout column small-12">
                    <legend><b>Parceiro | Datas</b></legend>
                    <div class="form-group col-md-9">
                        <label for="Nome">Parceiro *</label>
                        {!! Form::select('id_parceiro', [], null, ['class' => 'form-control select2_frete', 'required' => 'true', 'id' => 'frete']) !!}
                    </div>

                    <div class="form-group col-md-3">
                        <label>
                            <hr>
                        </label>
                        <a href="{{route('adicionarParceiro')}}" style="text-decoration: none"
                           class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Cadastrar Novo Parceiro</a>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Data Atual</label>
                        <input required="" name='data_hoje' type="text" placeholder="dd/mm/yyyy"
                               class="form-control datapicker" value="{{ $data->format('d/m/Y') }}"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Data Prevista Inicio</label>
                        <input required="" name='data_inicio' type="text" placeholder="dd/mm/yyyy"
                               class="form-control datapicker" value=""/>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Data Prevista Fim</label>
                        <input required="" name='data_fim' type="text" placeholder="dd/mm/yyyy"
                               class="form-control datapicker" value=""/>
                    </div>
                </fieldset>


                <fieldset class="callout column small-12">
                    <legend><b>Origem</b></legend>


                    <div class="form-group col-md-6">
                        {!! Form::label('cidade', 'Cidade Origem*') !!}
                        {!! Form::text('cidade_origem', null, ['class' => 'form-control', 'placeholder' => 'Cidade']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('estado', 'Estado Origem*') !!}
                        {!! Form::text('estado_origem', null, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'PR']) !!}
                    </div>

                </fieldset>

                <fieldset class="callout column small-12">
                    <legend><b>Destino</b></legend>

                    <div class="form-group col-md-6">
                        {!! Form::label('cidade', 'Cidade Destino*') !!}
                        {!! Form::text('cidade_destino', null, ['class' => 'form-control', 'placeholder' => 'Cidade']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('estado', 'Estado Destino*') !!}
                        {!! Form::text('estado_destino', null, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'PR']) !!}
                    </div>

                </fieldset>

                <fieldset class="callout column small-12">
                    <legend><b>Descrição do Item</b></legend>
                    {{--<hr style="border: 1px solid #ccc"/>--}}

                    <div class="form-group col-md-6">
                        {!! Form::label('tipo', 'Tipo *') !!}
                        {!! Form::text('tipo', null, ['class' => 'form-control', 'placeholder' => 'Carro, Barco, etc']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('identificacao', 'Identificacao *') !!}
                        {!! Form::text('identificacao', null, ['class' => 'form-control', 'placeholder' => 'Identificação']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('valor', 'Valor *') !!}
                        {!! Form::text('valor_item', null, ['class' => 'form-control', 'placeholder' => 'R$00,00']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('cor', 'Cor *') !!}
                        {!! Form::text('cor', null, ['class' => 'form-control', 'placeholder' => 'Azul']) !!}
                    </div>
                </fieldset>


                <fieldset class="callout column small-12">
                    <legend><b>Status | Coleta | Entrega</b></legend>

                    {{--<hr style="border: 1px solid #ccc"/>--}}

                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        {!! Form::select('status', array_merge([0 => 'Selecione um status'], $status), null, ['class' => 'form-control', 'required' => 'true', 'id' => 'status']) !!}
                    </div>
                    <div class="form-group col-md-3">
                        <label class="columns" for="unit-yes-no-coleta">
                            Tem Coleta?
                        </label>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="" for="unit-yes-no-entrega">
                            Tem Entrega?
                        </label>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="switch large">
                            <input class="switch-input" id="unit-yes-no5" type="checkbox">
                            <label class="switch-paddle" for="unit-yes-no5">
                                <span class="switch-active" aria-hidden="true">Sim</span>
                                <span class="switch-inactive" aria-hidden="true">Não</span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group col-md-3">
                        <div class="switch large">
                            <input class="switch-input" id="unit-yes-no4" type="checkbox">
                            <label class="switch-paddle" id="colet" for="unit-yes-no4">
                                <span class="switch-active" aria-hidden="true">Sim</span>
                                <span class="switch-inactive" aria-hidden="true">Não</span>
                            </label>
                        </div>
                    </div>


                    <div id="coletor" style="display: none;">
                        <div class="form-group col-md-6">
                            <label for="Nome">Coletor </label>
                            {!! Form::select('id_parceiro_coletor', [], null, ['class' => 'form-control select2_ce', 'required' => 'true', 'id' => 'id_coletor']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Nome">Valor Coleta </label>
                            {!! Form::text('valor_coleta', null, ['class' => 'form-control', 'placeholder' => 'R$00,00']) !!}
                        </div>
                    </div>
                    <div id="entregador" style="display: none;">

                        <div class="form-group col-md-6">
                            <label for="Nome">Entregador </label>
                            {!! Form::select('id_parceiro_entregador', [], null, ['class' => 'form-control select2_ce', 'required' => 'true', 'id' => 'id_entrega']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Nome">Valor Entrega </label>
                            {!! Form::text('valor_entrega', null, ['class' => 'form-control', 'placeholder' => 'R$00,00']) !!}
                        </div>

                    </div>

                </fieldset>
                <script>

                </script>
                <fieldset class="callout column small-12">
                    <legend><b>Valor Total | Informações</b></legend>

                    <div class="form-group col-md-6">
                        {!! Form::label('valor_total', 'Valor Total *') !!}
                        {!! Form::text('valor_total', null, ['class' => 'form-control', 'placeholder' => 'R$00,00']) !!}
                    </div>

                    <div class="form-group col-md-12">
                        {!! Form::label('informacoes_complementares', 'Informações Complementares *') !!}
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
                                {!! Form::select('id_parceiro_coletor', [], null, ['class' => 'form-control', 'id' => 'coletor']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valor_coleta">Valor</label>
                                {!! Form::text('valor_coleta', null, ['class' => 'form-control']) !!}
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>

                <!-- Tem Entrega -->


                <div class="form-group col-md-12" style="display: none;">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Entrega</h3>

                            <div class="box-tools pull-right">
                                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>--}}
                                {{--</button>--}}
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="id_parceiro_coletor">Entregador</label>
                                {!! Form::select('id_parceiro_entregador', [], null, ['class' => 'form-control', 'id' => 'coletor']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valor_coleta">Valor</label>
                                {!! Form::text('valor_entrega', null, ['class' => 'form-control']) !!}
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>


                <div class="form-group col-md-6">
                    <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> Cadastrar</button>
                    {{--{!! Form::submit('Cadastrar', ['class' => 'btn btn-primary', 'id' => 'botao']) !!}--}}
                    <a class="btn btn-info" href="{{route('listarFretes')}}">Voltar</a>
                    <button type="reset" class="btn">Limpar</button>
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

                <?php $pessoa = "<script>$('.pessoa').val();</script>"?>
                <?php $sexo =  '<script>$(".sexo").val();</script>'?>
                <div class="form-group col-md-6">
                    <label for="Nome">Nome</label>
                    {!! Form::text('nome', null, ['class' => 'form-control nome_parceiro', 'disabled' => 'true']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('documento', ['class' => 'pessoa'] == "juridica" ? 'CNPJ *': 'CPF *') !!}
                    <?php var_dump($pessoa) ?>
                    @if($pessoa == "juridica")
                        {!! Form::text('documento', null, ['class' => 'form-control documento', 'disabled' => 'true', 'id' => 'cnpj']) !!}
                    @else
                        {!! Form::text('documento', null, ['class' => 'form-control documento', 'disabled' => 'true', 'id' => 'cpf']) !!}
                    @endif
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
                    {!! Form::label('cep', 'Cep') !!}
                    {!! Form::text('cep', null, ['class' => 'form-control cep', 'disabled' => 'true', 'id' => 'cep']) !!}
                </div>

                <div class="form-group col-md-6">
                    {{--{!! Form::label('site', 'Site') !!}--}}
                    {{--{!! Form::text('site', null, ['class' => 'form-control']) !!}--}}
                </div>

                @if($pessoa == \App\Parceiro::PESSOA_JURIDICA)
                    <div class="form-group col-md-6">
                        {!! Form::label('fantasia', 'Fantasia *') !!}
                        {!! Form::text('fantasia', null, ['class' => 'form-control fantasia', 'disabled' => 'true']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('inscricao_estadual', 'Inscrição Estadual *') !!}
                        {!! Form::text('inscricao_estadual', null, ['class' => 'form-control inscricao_estadual', 'disabled' => 'true']) !!}
                    </div>
                @else
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



                    <div class="form-group col-md-6">
                        {!! Form::label('deficiencia_fisica', 'Deficiência Física') !!}
                        {!! Form::text('deficiencia_fisica', null , ['class' => 'form-control deficiencia_fisica', 'disabled' => 'true']) !!}
                    </div>

                @if($sexo == 'm')
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


                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                {{--{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}--}}
            </div>
            {{--{!! Form::close() !!}--}}
        </div><!--box-primary-->
    </div><!--modal-content-->
</div>  <!--modal-dialog-->
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
    <script src="{{url('/assets/js/cad-frete.js')}}"></script>
    <script src="{{url('/assets/js/ischeck.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
@endsection

@endsection