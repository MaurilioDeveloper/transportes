@extends('painel.template.template')

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


{{--<!----}}
<div class="modal fade bs-example-modal-lg5 in" id="tipoOcorrencia" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="modal-title" id="myModalLabel">Cadastrar Tipo Ocorrência</h3>
                </div>

                <!-- form start -->
                <div class="box-body">
                    <h4 class="box-title">Os campos com * são obrigatórios</h4>
                    {!! Form::open(['route' => 'postOcorrencia', 'class' => 'form']) !!}

                    <div class="form-group col-md-12">
                        {!! Form::label('nome', 'Tipo Ocorrência *') !!}
                        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div><!--box-primary-->
        </div><!--modal-content-->
    </div>  <!--modal-dialog-->
</div>

{{--<!----}}
<div class="modal fade bs-example-modal-lg5 in" id="ocorrencia" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg5">
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="modal-title" id="myModalLabel">Cadastrar Ocorrência</h3>
                </div>

                <!-- form start -->
                <div class="box-body">
                    <h4 class="box-title">Os campos com * são obrigatórios</h4>
                    {!! Form::open(['route' => 'postOcorrencia', 'class' => 'form']) !!}
                    <div class="form-group col-md-12">
                        {!! Form::label('data', 'Data *') !!}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::input('data', null, null,  ['class' => 'form-control pull-right datapicker', 'id' => '']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('tipo_ocorrencia', 'Tipo De Ocorrência *') !!}
                        {!! Form::select('tipo_ocorrencia', [], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        <div class=""><a href="#" class="btn btn-info" id="botao-tipo-ocorrencia"><i class="fa fa-plus"></i> Cadastrar Tipo de Ocorrências</a></div>
                    </div>
                    <div class="form-group col-md-12">
                        <div style="display: none;">
                            {!! Form::input('text', 'id_user', auth()->user()->id, ['class' => '','style' => 'width:217px; background: #f0f0f0 !important; color: #aaa !important; border: #ccc;']) !!}
                        </div>
                        {!! Form::label('usuario', 'Usuario Autor *') !!}
                        {!! Form::select('usuario', [auth()->user()->name], auth()->user()->name, ['class' => 'form-control', 'disabled' => 'true']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('descricao', 'Descrição *') !!}
                        {!! Form::textarea('descricao', null, ['class' => 'form-control']) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div><!--box-primary-->
        </div><!--modal-content-->
    </div>  <!--modal-dialog-->
</div>

<!-- Main content -->
    {{--<section class="content">--}}
        <div class="row">
            <div class="col-md-12">

                <div class='box box-primary'>

                <div class="box-header with-border">
                        <h3 class="box-title">Os campos com * são obrigatórios</h3>
                        <div class="pull-right"><a href="#" class="btn btn-info" data-toggle="modal" data-target="#tipoOcorrencia"><i class="fa fa-gear"></i> Tipo de Ocorrências</a></div>
                        <div class="pull-right" style="margin-right: 10px"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#ocorrencia"><i class="fa fa-gear"></i> Ocorrências</a></div>
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
    <script type="text/javascript" src="{{url('/assets/js/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/data-picker.js')}}"></script>
@endsection
@endsection
{{--
<section class="content-header">
@if ( isset($parceiro->id) )
    <h1>EDIÇÃO DO USUÁRIO</h1>
@else
    <h1>CADASTRO DE USUÁRIO</h1>
@endif

<ol class="breadcrumb">
    <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
    @if ( isset($parceiro->id) )
        <li class="active">Edição do Usuário</li>
    @else
        <li class="active">Cadastro de Usuário</li>
    @endif
</ol>
</section>
<div class='content'>
<div class='row'>
    <div class='col-md-12'>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Os campos com * são obrigatórios</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if(isset($errors) && count($errors) > 0 )
                <div class="alert alert-warning">
                    @foreach($errors->all() as $error)
                        <span style="color: black">{{$error}}</span> <br/>
                    @endforeach
                </div>
            @endif
            @if ( isset($parceiro->id) )
                <form name='form' method='post' action='/m1-transportes/public/painel/parceiros/{{$parceiro->id}}'>
                    <input name="_method" value="PUT" type="hidden">
                    @else
                        <form name='form' method='post' action='/m1-transportes/public/painel/parceiros'>
                            @endif
                            {{ csrf_field() }}

                            <div class="box-body">
                                <div class="form-group col-md-6">
                                    {{--<label for="Nome">Nome *</label>--}}
{{--<input type="text" value="@if(isset($parceiro->name)){{$parceiro->name}}@else{{old('name')}}@endif" name='name' placeholder="Insira o Nome" class='form-control'>--}}
{{--</div>--}}
{{--<div class="form-group col-md-6">--}}
{{--<label for="exampleInputEmail">E-mail *</label>--}}
{{--<input type="text" value="@if(isset($parceiro->email)){{$parceiro->email}}@else{{old('email')}}@endif" name='email' placeholder="Insira um Email" class='form-control'>--}}
{{--</div>--}}
{{--<div class="form-group  col-md-6">--}}
{{--<label for="Senha">Senha *</label>--}}
{{--<input type="password" value="{{old('password')}}" name='password' placeholder="Insira uma Senha" class='form-control'>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="box-footer col-md-6">--}}
{{--<button type="submit" class="btn btn-primary">Salvar</button>&nbsp;&nbsp;<button type="reset" class="btn">Limpar</button>--}}
{{--</div>--}}
{{--</form>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}