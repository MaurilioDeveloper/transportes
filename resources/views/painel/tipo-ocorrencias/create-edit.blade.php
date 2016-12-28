@extends('painel.template.template')

@section('styles-head')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">

            <div class='box box-primary'>

                <div class="box-header with-border">
                    <h3 class="box-title">Os campos com * são obrigatórios</h3>
                </div>

                <div class="box-body">

                    {{--@include('painel.errors._errors_form')--}}
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn" role="alert"></div>
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc" role="alert">Tipo de Ocorrência Cadastrado com Sucesso</div>

                    @if(isset($frete->id) && $frete->id > 0)
                        {!! Form::model($frete, ['route' => ['updateTipoOcorrencia','tipo-ocorrencia' => $tipoOcorrencia->id], 'class' => 'form', 'send' => 'updateFrete', 'name' => 'form', 'method' => 'PUT']) !!}

                    @else
                        {!! Form::open(['route' => 'postTipoOcorrencia', 'class' => 'form', 'name' => 'form-tipo-ocorrencia', 'send' => '/painel/parceiros/postTipoOcorrencia']) !!}
                    @endif


                    <div class="form-group col-md-12">
                        <label>Nome</label>
                        <input required="" name='nome' type="text" placeholder="Nome"
                               class="form-control"/>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> Cadastrar</button>
                        {{--{!! Form::submit('Cadastrar', ['class' => 'btn btn-primary', 'id' => 'botao']) !!}--}}
                        <a class="btn btn-info" href="{{route('listaTipoOcorrencias')}}">Voltar</a>
                        <button type="reset" class="btn">Limpar</button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


@section('scripts-footer')
    <script src="{{url('/assets/js/cadastros/cad-tipo-ocorrencia.js')}}"></script>
@endsection


@endsection