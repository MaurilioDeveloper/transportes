@extends('painel.template.template')

@section('content')

@section('title')
    <h1>{{ $titulo }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('listarParceiros') }}"><i class="fa fa-briefcase"></i> Parceiros</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class='box box-primary'>

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

                    <div class="box-body">
                        <h4>{{$pessoa == \App\Parceiro::PESSOA_JURIDICA ? 'Pessoa Júridica': 'Pessoa Física'}}</h4>
                        @include('painel.errors._errors_form')

            {!! Form::model($parceiro, ['route' => ['parceiros.update','client' => $parceiro->id], 'class' => 'form', 'method' => 'PUT']) !!}

            @include('painel.parceiros._form')

            <div class="form-group col-md-6">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                <a class="btn btn-info" href="{{route('parceiros.index')}}">Voltar</a>
                <button type="reset" class="btn">Limpar</button>
            </div>
            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('scripts-footer')
    <script src="{{url('/assets/js/jquery.blockUI.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/masks.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/add-new-field.js')}}"></script>
@endsection
@endsection