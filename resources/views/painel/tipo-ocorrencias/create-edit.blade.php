@extends('painel.template.template')

@section('content')
    <div class="overlay-loading" style="display: none;"></div>
    <div class="row">
        <div class="col-md-6">

            <div class='box box-primary'>

                <div class="box-header with-border">
                    <h3 class="box-title">Os campos com * são obrigatórios</h3>
                </div>

                <div class="box-body">

                    {{--@include('painel.errors._errors_form')--}}
                    <div style="display: none; text-align: center; width: 100%;" class="alert alert-warning msg-warn-tipo" role="alert"></div>
                    @if(isset($tipoOcorrencia->id) && $tipoOcorrencia->id > 0)
                        <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc-tipo" role="alert">Tipo de Ocorrência Alterado com Sucesso</div>
                    @else
                        <div style="display: none; text-align: center; width: 100%;" class="alert alert-success msg-suc-tipo" role="alert">Tipo de Ocorrência Cadastrado com Sucesso</div>
                    @endif
{{--                    {{$tipoOcorrencia}}--}}

                    @if(isset($tipoOcorrencia->id) && $tipoOcorrencia->id > 0)
                        {!! Form::model($tipoOcorrencia, ['route' => ['updateTipoOcorrencia','tipoOcorrencia' => $tipoOcorrencia->id], 'class' => 'form', 'send' => '/painel/tipo-ocorrencias/update/'.$tipoOcorrencia->id, 'name' => 'form', 'method' => 'PUT']) !!}

                    @else
                        {!! Form::open(['route' => 'postTipoOcorrencia', 'class' => 'form', 'name' => 'form-tipo-ocorrencia', 'send' => '/painel/parceiros/postTipoOcorrencia']) !!}
                    @endif


                    <div class="form-group col-md-12">
                        <label>Nome</label>
                        <input required="" name='nome' type="text" placeholder="Nome" value="{{$tipoOcorrencia->nome or old('nome')}}"
                               class="form-control"/>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" id="botao" class="btn btn-primary"><img src="{{url('/assets/imgs/carregar.gif')}}" class="load" alt="Carregando" style="display: none; width: 30px; height: 30px;"/> Cadastrar</button>
                        {{--{!! Form::submit('Cadastrar', ['class' => 'btn btn-primary', 'id' => 'botao']) !!}--}}
                        <a class="btn btn-info" href="{{route('listagemTO')}}">Voltar</a>
                        <button type="reset" class="btn">Limpar</button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


@section('scripts-footer')
    <script src="{{url('/assets/js/cadastros/cad-tipo-ocorrencia-main.js')}}"></script>
@endsection


@endsection