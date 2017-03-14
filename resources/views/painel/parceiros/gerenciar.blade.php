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
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('parceiros.index') }}"><i class="fa fa-briefcase"></i> Parceiros</a></li>
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
                        <a class="btn btn-primary btn-sm" href="{{ route('parceiros.create',['pessoa' => \App\Models\Parceiro::PESSOA_FISICA]) }}"><i class="fa fa-user-secret"></i> Pessoa Física</a>
                        <a class="btn btn-warning btn-sm" href="{{ route('parceiros.create',['pessoa' => \App\Models\Parceiro::PESSOA_JURIDICA]) }}"><i class="fa fa-briefcase"></i> Pessoa Jurídica</a>
                    </div>
                    <!-- /.box-body -->
                </form><!-- /form end -->
            </div>
            <!-- /.box -->
        </div><!-- /col -->
    </div><!-- /row -->
@endsection

@section('scripts-footer')
    <!--
    <script>
        $(function () {
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
    -->
@endsection