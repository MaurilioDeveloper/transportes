<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login M1 Transportes</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{url('/assets/css/bootstrap.min.css')}}" />

    <!-- Theme -->
    <link rel="stylesheet" href="{{url('/assets/css/bootstrap-theme.min.css')}}" />
    <link rel="stylesheet" href="{{url('/assets/css/style.css')}}" />

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- iCheck -->
    {{--<link rel="stylesheet" href="{{url("plugins/iCheck/square/blue.css")}}" />--}}

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>M1</b> Transportes</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Faça login para entrar no sistema</p>

        @yield('content-form')

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- iCheck -->
{{--<script src="{{url("plugins/iCheck/icheck.min.js")}}"></script>--}}
<script type="text/javascript" src="{{url('/assets/js/login.js')}}"></script>
</body>
</html>