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
                <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Viagem Cadastrada com Sucesso</div>

                @if(isset($viagem->id) && $viagem->id > 0)
                    {!! Form::model($viagem, ['route' => ['updateViagem','viagem' => $viagem->id], 'class' => 'form', 'send' => 'updateViagem', 'name' => 'form', 'method' => 'PUT']) !!}

                @else
                    {!! Form::open(['route' => 'cadastrarViagem', 'class' => 'form', 'send' => 'cadastrar-viagem', 'name' => 'form-viagem']) !!}
                @endif


                <div class="form-group col-md-12">
                    <input type="hidden"  />
                    <label for="id_parceiro">Parceiro Viagem*</label>
                    {{--                        {!! Form::select('id_parceiro', [], null, ['class' => 'form-control select2_frete', 'required' => 'true', 'id' => 'frete']) !!}--}}
                    <select class="form-control select2_viagem" id="viagem" name="id_parceiro_viagem">
                        @if(isset($viagem->id_parceiro_viagem))
                            <option value="{{$viagem->id_parceiro_viagem}}" selected>{{$viagemNome}}</option>
                        @else
                            <option value="0" selected>Selecione um parceiro</option>
                        @endif
                    </select>
                </div>
                <div id="dados" style="display: none;">
                    <hr style="border: 1px solid #3c8dbc"/>

                    <div class="form-group col-md-6">
                        {!! Form::select('id_caminhao', [0 => 'Selecione um caminhão'], isset($caminhao) or old('id_caminhao'), ['class' => 'form-control', 'id' => 'caminhao']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::select('id_motorista', [0 => 'Selecione um motorista'], isset($motorista) or old('id_motorista'), ['class' => 'form-control', 'id' => 'motorista']) !!}
                    </div>
                    <div class="form-group col-md-6">
                            <label>Data Prevista Inicio *</label>
                            <input required="" name='data_inicio' type="text" placeholder="__/__/____"
                                   class="form-control datapicker" value="{{$data_inicio or old('data_inicio')}}"/>
                    </div>
                    <div class="form-group col-md-6">
                            <label>Horario de Inicio *</label>
                            <input required="" name='horario_inicio' type="text"
                                   class="form-control timepicker" value=""/>
                    </div>
                    <div class="form-group col-md-6">
                            <label>Data Prevista Termino *</label>
                            <input required="" name='data_fim' type="text" placeholder="__/__/____"
                                   class="form-control datapicker" value="{{$data_inicio or old('data_inicio')}}"/>
                    </div>
                    <div class="form-group col-md-6">
                            <label>Horario de Termino *</label>
                            <input required="" name='horario_fim' type="text"
                                   class="form-control timepicker" value=""/>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="status">Status *</label>
                        {!! Form::select('status', \App\Viagem::STATUS, isset($viagem->status) or old('status'), ['class' => 'form-control', 'required' => 'true', 'id' => 'status']) !!}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('cidade', 'Cidade Origem*') !!}
                        {{--{!! Form::text('cidade_origem', null, ['class' => 'form-control', 'placeholder' => 'Cidade', 'value' => "@if(isset($frete->cidade_origem)){{$frete->cidade_origem}}@else{{old('cidade_origem')}}@endif"]) !!}--}}
                        <input type="text" name="cidade_origem" class="form-control" placeholder="Cidade" value="@if(isset($viagem->cidade_origem)){{$viagem->cidade_origem}}@else{{old('cidade_origem')}}@endif" />
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::label('estado', 'Estado Origem *') !!}
                        {{--                        {!! Form::text('estado_origem', null, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'PR']) !!}--}}
                        <input type="text" name="estado_origem" class="form-control" placeholder="Estado" value="@if(isset($viagem->estado_origem)){{$viagem->estado_origem}}@else{{old('estado_origem')}}@endif" />
                    </div>

                    {{--</fieldset>--}}

                    {{--<fieldset class="callout column small-12">--}}
                    {{--<legend><b>Destino</b></legend>--}}

                    <div class="form-group col-md-3">
                        {!! Form::label('cidade', 'Cidade Destino *') !!}
                        {{--{!! Form::text('cidade_destino', null, ['class' => 'form-control', 'placeholder' => 'Cidade']) !!}--}}
                        <input type="text" name="cidade_destino" class="form-control" placeholder="Cidade" value="@if(isset($frete->cidade_destino)){{$frete->cidade_destino}}@else{{old('cidade_destino')}}@endif" />
                    </div>

                    <div class="form-group col-md-3">
                        {!! Form::label('estado', 'Estado Destino *') !!}
                        {{--{!! Form::text('estado_destino', null, ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'PR']) !!}--}}
                        <input type="text" name="estado_destino" class="form-control" placeholder="Estado" value="@if(isset($frete->estado_destino)){{$frete->estado_destino}}@else{{old('estado_destino')}}@endif" />
                    </div>
                    <input type="hidden" id="id_parceiro" />
                    <input type="hidden" id="id_frete" name="id_frete" />
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#adicionarFrete"><i class="fa fa-plus-circle"></i> ADICIONAR</button>
                    </div>

                    <div class="form-group col-md-12">
                        <hr style="border: 1px solid #3c8dbc"/>
                        {!! Form::submit('Cadastrar', ['class' => 'btn btn-primary', 'id' => 'botao', 'send' => 'cadastrarViagem']) !!}
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
                <h4 class="modal-title" id="myModalLabel">Adicionar um Frete</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #2e6da4; color: white">
                            <th>Nome Parceiro</th>
                            <th>Modelo</th>
                            <th>Identificação</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($fretes as $frete)
                        {{--{{$fretes}}--}}
                        <tr class="success">
                            <td>{{$frete->nome}}</td>
                            <td>{{$frete->tipo}}</td>
                            <td>{{$frete->identificacao}}</td>
                            <td>{{$frete->cidade_origem}}</td>
                            <td>{{$frete->cidade_destino}}</td>
                            <td><button class="btn btn-success btn-sm" onclick="adicionarFrete({{$frete->id}})" id-frete="{{$frete->id}}"><i class="fa fa-plus-circle"></i> Adicionar</button></td>
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

@section('scripts-footer')
    {{--<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{url('/assets/js/cadastros/cad-viagem.js')}}"></script>
    <script src="{{url('/assets/js/ischeck.js')}}"></script>
    <script src="{{url('/assets/js/vendor/timepicki.js')}}"></script>
    <script>$('.timepicker').timepicki({show_meridian:false});</script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/maskMoney.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks/masks.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
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
    {{--<script src="{{url('/assets/js/datatable-lists/list-viagem.js')}}"></script>--}}
@endsection

@endsection