@extends('painel.template.template')

@section('styles-head')
    <!-- CSS só desta Página -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{url('/assets/plugins/iCheck/all.css')}}">
@endsection

@section('title')
    <h1>{{ $titulo }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('listarParceiros') }}"><i class="fa fa-truck"></i> Parceiros</a></li>
        <li class="active">{{ $titulo }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados Principais</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="tipoPessoaF">Pessoa Física</label>
                            <input type="radio" id="tipoPessoaF" name="tipoPessoa" value="F" class="minimal">
                        </div>
                        <div class="form-group">
                            <label for="tipoPessoaJ">Pessoa Jurídica</label>
                            <input type="radio" id="tipoPessoaJ" name="tipoPessoa" value="J" class="minimal">
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form><!-- /form end -->
            </div>
            <!-- /.box -->
        </div><!-- /col -->
    </div><!-- /row -->
@endsection

@section('scripts-footer')
    <script>
        $(function () {
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@endsection