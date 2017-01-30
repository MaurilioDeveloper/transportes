@extends('painel.template.template')

@section('styles-head')
    {{--<link type="text/css" href="css/custom-theme/jquery-ui-1.8.20.custom.css" rel="stylesheet" />--}}
    <link href="{{url('/assets/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{url('/assets/css/app.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/plugin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/tables/datatables/css/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/autoFill.bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/buttons.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/colReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/fixedColumns.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/fixedHeader.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/keyTable.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/responsive.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/rowReorder.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/scroller.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{url('/assets/plugins/tables/datatables/css/select.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/timepicki.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/loading.css')}}"/>

@endsection

@section('content')

@section('title')
    <h1>{{ $titulo }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{--<li><a href="{{ route('listarFretes') }}"><i class="fa fa-plus-circle"></i> Cadastra Viagens</a></li>--}}
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

<div class="overlay-loading" style="display: none;"><span>Carregando...</span></div>
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

                @if(isset($viagem->id) && $viagem->id > 0)
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Viagem Alterada com Sucesso</div>
                    {!! Form::model($viagem, ['route' => ['updateViagem','viagem' => $viagem->id], 'class' => 'form', 'send' => '/painel/viagens/update/'.$viagem->id, 'name' => 'form-viagem', 'method' => 'PUT']) !!}
                    <input type="hidden" id="edicao" value="{{$viagem->id}}" />
                    <input type="hidden" id="parceiro-viagem" value="{{$viagem->id_parceiro_viagem}}" />

                @else
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Viagem Cadastrada com Sucesso</div>
                    {!! Form::open(['route' => 'cadastrarViagem', 'class' => 'form', 'send' => 'cadastrar-viagem', 'name' => 'form-viagem', 'method' => 'POST']) !!}
                @endif


                <div class="form-group col-md-12">
                    <input type="hidden"  />
                    <label for="id_parceiro">Parceiro Viagem*</label>
                    {{--                        {!! Form::select('id_parceiro', [], null, ['class' => 'form-control select2_frete', 'required' => 'true', 'id' => 'frete']) !!}--}}
                    <select class="form-control select2_viagem" id="viagem" name="id_parceiro_viagem">
                        @if(isset($viagem->id_parceiro_viagem))
                            <option value="{{$viagem->id_parceiro_viagem}}" selected>{{$viagemNome}}</option>
                        @else
                            @if(isset($idViagemParceiro))
                                <option value="{{$idViagemParceiro}}" selected>{{$nomeViagemParceiro}}</option>
                            @else
                                <option value="0" selected>Selecione um parceiro</option>
                            @endif
                        @endif
                    </select>
                </div>
                <div id="dados" style="@if(!isset($idViagemParceiro) && !isset($viagem->id_parceiro)) display: none; @endif">
                    <hr style="border: 1px solid #3c8dbc"/>
                    <input id="idMotorista" value="@if(isset($viagem->id_motorista)){{$viagem->id_motorista}}@endif" type="hidden" />
                    <input id="idCaminhao" value="@if(isset($viagem->id_caminhao)){{$viagem->id_caminhao}}@endif" type="hidden" />

                    <div class="form-group col-md-6">
                        <label for="id_caminhao">Caminhão Viagem</label>
                        <select name="id_caminhao" class="form-control" id="caminhao">
                            <option value="0">Selecione um caminhão</option>
                            @if(isset($dadosCaminhao))
                                {{--{{$dadosCaminhao}}--}}
                                @foreach($dadosCaminhao as $caminhao)
{{--                                    {{$caminhao}}--}}
                                    <option value="{{$caminhao->id}}">{{$caminhao->placa}} - {{$caminhao->modelo}}</option>
                                @endforeach
                            @endif
                        </select>
{{--                        {!! Form::select('id_caminhao', [0 => 'Selecione um caminhão'], isset($nomeCaminhao) or old('id_caminhao'), ['class' => 'form-control', 'id' => 'caminhao']) !!}--}}
                    </div>
                    {{--<input id="nomeMotorista" value="{{$nomeMotorista}}" type="hidden" />--}}
{{--                    {{dd($viagem)}}--}}
                    <div class="form-group col-md-6">
                        <label for="id_motorista">Motorista Viagem</label>
                        <select name="id_motorista" class="form-control" id="motorista">
                            <option value="0">Selecione um motorista</option>
                            @if(isset($dadosMotorista))
                                {{--{{$dadosCaminhao}}--}}
                                @foreach($dadosMotorista as $motorista)
                                    {{--                                    {{$caminhao}}--}}
                                    <option value="{{$motorista->id}}">{{$motorista->nome}}</option>
                                @endforeach
                            @endif
                        </select>
{{--                        {!! Form::select('id_motorista', [0 => 'Selecione um motorista'], null, ['class' => 'form-control', 'id' => 'motorista']) !!}--}}
                    </div>
                        <div class="form-group col-md-3">
                            <label>Data Prevista Início</label>
                            <input  name='data_inicio' type="text" placeholder="__/__/____"
                                   class="form-control datapicker" value="{{$viagem->data_inicio or old('data_inicio')}}"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label>Horário de Início</label>
                            <input name='horario_inicio' type="text" placeholder="__:__"
                                   class="form-control timepicker" value="{{$viagem->horario_inicio or old('horario_inicio')}}"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label>Data Prevista Término</label>
                            <input  name='data_fim' type="text" placeholder="__/__/____"
                                   class="form-control datapicker" value="{{$viagem->data_fim or old('data_fim')}}"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label>Horário de Término</label>
                            <input  name='horario_fim' type="text" placeholder="__:__"
                                   class="form-control timepicker" value="{{$viagem->horario_inicio or old('horario_fim')}}"/>
                    </div>
                    @if(isset($viagem->id) && $viagem->id > 0)
                        <div class="form-group col-md-9">
                    @else
                        <div class="form-group col-md-12">
                    @endif
                        <label for="status">Status *</label>
{{--                        {{$viagem->status}}--}}
                        <input type="hidden" id="status" value="@if(isset($viagem->status)){{$viagem->status}}@endif"  />
{{--                        {{$viagem->status}}--}}
                        <select name="status" class="form-control" id="status-select" required>
                            <option value="0">Selecione um Status</option>
                            @foreach(\App\Viagem::STATUS as $key => $value)
                                @if(isset($viagem->status) && $value === $viagem->status)
                                    <option value="{{$key}}" selected>{{$value}}</option>
                                            {{--{{old('status')}}--}}
                                @else
                                    <option value="{{$key}}" {{old('status') == $value ? 'selected="selected"' : ''}}>{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
{{--                        {!! Form::select('status', \App\Viagem::STATUS, isset($viagem->status) or old('status'), ['class' => 'form-control', 'required' => 'true', 'id' => 'status']) !!}--}}
                    </div>
                    @if(isset($viagem->id) && $viagem->id > 0)
                        <div class="form-group col-md-3">
                            <label><hr/></label>
                            <a style="text-decoration: none" class="btn btn-info" onclick="verHistorico()"><i class="fa fa-history"></i> Ver Histórico <span class="badge badge-primary">@if(isset($historicoViagens)){{count($historicoViagens)}}@endif</span></a>
                        </div>
                    @endif
                    <div class="form-group col-md-6">
                        {!! Form::label('cidade', 'Cidade Origem *') !!}
                        <select name="id_cidade_origem" class="form-control" id="cidade_origem" required>
                            <option value="0">Selecione uma Cidade</option>
                            {{--                            {{$estados}}--}}
                            @if(isset($cidades))
                                @foreach($cidades as $key => $value)
                                    @if(isset($viagem->id_cidade_origem) && $key === $viagem->id_cidade_origem)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        {{--{{old('status')}}--}}
                                    @else
                                        <option value="{{$key}}" {{old('cidade_origem') == $value ? 'selected="selected"' : ''}}>{{$value}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        {{--{!! Form::text('cidade_origem', null, ['class' => 'form-control', 'placeholder' => 'Cidade', 'value' => "@if(isset($frete->cidade_origem)){{$frete->cidade_origem}}@else{{old('cidade_origem')}}@endif"]) !!}--}}
                        {{--<input required type="text" name="cidade_origem" class="form-control" placeholder="Cidade" value="@if(isset($viagem->cidade_origem)){{$viagem->cidade_origem}}@else{{old('cidade_origem')}}@endif" />--}}
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
                                    @if(isset($viagem->id_cidade_destino) && $key === $viagem->id_cidade_destino)
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
                    <div class="form-group col-md-12">
                        {!! Form::label('informacoes_complementares', 'Informações Complementares') !!}
                        {!! Form::textarea('informacoes_complementares', null, ['class' => 'form-control']) !!}
                    </div>


                    <input type="hidden" id="id_parceiro" />
                    <input type="hidden" id="id_frete"  value="{{$viagem->id_frete or 0}}"/>
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#adicionarFrete"><i class="fa fa-plus-circle"></i> ADICIONAR FRETES A ESTA VIAGEM</button>
                    </div>

                    <div class="form-group col-md-12">
                        <label style="">Frete Adicionado a Viagem</label>
                        <hr style="border: 1px solid #3c8dbc"/>
                    </div>

                    <div id="noneFrete" class="form-group col-md-12">
                        <h4 style="text-align: center; font-style: italic;">Nenhum Frete Adicionado até o momento</h4>
                    </div>

                    <div class="form-group col-md-12" style="display: none;" id="freteAdicionado">
                    <table class="table table-bordered" id="frete-adicionado-table">
                        <thead>
                        <tr style="background: #2e6da4; color: white">
                            <th>Nome Parceiro</th>
                            <th>Modelo</th>
                            <th>Identificação</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th style="width: 180px">Custo</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody id="freteAd">
                        {{--{{$fretesAdicionados}}--}}
                        @if(isset($fretesAdicionados))
                            @forelse($fretesAdicionados as $fretesAd)
{{--                                <input type="hidden" value="{{$fretesAd->id}}" id="frete-disable{{$fretesAd->id}}" />--}}
                                <tr class="warning" id="freteTable{{$fretesAd->id}}">
                                    <td>{{$fretesAd->nome}}</td>
                                    <td>{{$fretesAd->tipo}}</td>
                                    <td>{{$fretesAd->identificacao}}</td>
                                    <td>{{$fretesAd->cidade_origem}}</td>
                                    <td>{{$fretesAd->cidade_destino}}</td>

                                    <td><input type="text" class="form-control moeda" name="custos[{{$fretesAd->id}}]" data-prefix="R$" value="{{$fretesAd->custos}}"/></td>

                                    <td><a onclick="removerFrete({{$fretesAd->id}})" class="remover btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                </tr>

                            @empty
                                <tr class="nenhum"><td class="warning" style="text-align: center" colspan="6">Nenhum frete adicionado até o momento</td></tr>
                            @endforelse
                        @endif
{{----}}
                        </tbody>
                    </table>
                    </div>

                    <div id="fretesPreenchidos">
                        <?php $i=0 ?>
                        @if(isset($fretesAdd) && count($fretesAdd) > 0)
                            @foreach($fretesAdd as $viagemFrete)
                                <div id="listaFrete">
                                    <input type="hidden" class="frete_id" name="fretes[{{$viagemFrete->id_frete}}]" value="{{$viagemFrete->id_frete}}"/>
                                </div>
                                <?php $i++ ?>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <hr style="border: 1px solid #3c8dbc"/>
                        <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> @if(isset($viagem->id) && $viagem->id > 0) Salvar @else Cadastrar @endif</button>
                        {{--<button type="submit" class="btn btn-primary">Cadastrar</button>--}}
                        <a class="btn btn-info" href="{{route('listaViagens')}}">Voltar</a>
                        <button type="reset" class="btn">Limpar</button>
                    </div>

                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adicionarFrete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Adicionar um Frete (Aguardando Embarque)</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #2e6da4; color: white">
                            <th>Nome Parceiro</th>
                            <th>Modelo</th>
                            <th>Identificação</th>
                            {{--<th>Status</th>--}}
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($fretes as $frete)
                        <input type="hidden" value="{{$frete->id}}" class="freteListaId" />
                        <tr class="success">
                            <td>{{$frete->nome}}</td>
                            <td>{{$frete->tipo}}</td>
                            <td>{{$frete->identificacao}}</td>
                            {{--<td>{{$frete->status}}</td>--}}
                            <td>{{$frete->cidade_origem}}</td>
                            <td>{{$frete->cidade_destino}}</td>
                            <td><button class="btn btn-success btn-sm" onclick="adicionarFrete({{$frete->id}})" id="id-frete{{$frete->id}}" id-frete="{{$frete->id}}"><i class="fa fa-plus-circle"></i> Adicionar</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="warning" style="text-align: center;">Nenhum dado cadastrado</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="lista-historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #75b9e6; color: #000; font-weight: bold">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 style="text-align: center;" class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Histórico da Viagem (Mudança de STATUS)</h4>
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
                    @if(isset($historicoViagens))
                        @forelse($historicoViagens as $historico)
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

@section('scripts-footer')
    {{--<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{url('/assets/js/ischeck.js')}}"></script>
    <script src="{{url('/assets/js/vendor/timepicki.js')}}"></script>
    <script>$('.timepicker').timepicki({show_meridian:false});</script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/maskMoney.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>--}}
    <script src="{{url('/assets/plugins/tables/datatables/js/datatables.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/jszip.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/vfs_fonts.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.autoFill.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/autoFill.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.colVis.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.colReorder.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.fixedColumns.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/responsive.bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.rowReorder.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{url('/assets/plugins/tables/datatables/js/dataTables.select.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
    <script src="{{url('/assets/js/cadastros/cad-viagem.js')}}"></script>
    {{--<script src="{{url('/assets/js/datatable-lists/list-viagem.js')}}"></script>--}}
@endsection

@endsection