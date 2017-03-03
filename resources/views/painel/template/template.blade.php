<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>M1 Transportes - {{$titulo or 'Painel M1 Transportes'}}</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{url('/assets/plugins/iCheck/all.css')}}">
        <link rel="stylesheet" href="{{url('/assets/plugins/colorpiker/colorpiker.css')}}">
        <link rel="stylesheet" href="{{url('/assets/css/bootstrap.min.css')}}">

        <!-- Theme -->
        <link rel="stylesheet" href="{{url('/assets/css/style.css')}}">
{{--        {{ Html::style('css/style.css') }}--}}
        <link rel="stylesheet" href="{{url('/assets/css/style2.css')}}">

        <!-- Icon Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- jQuery UI -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

{{--        <script src="{{url('/assets/js/jquery-1.6.2.js')}}"></script>--}}
        <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
        <script src="{{url('/assets/js/vendor/angular.min.js')}}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="icon" href="{{url('/assets/imgs/logo-top.png')}}"/>
        {{--<script--}}
            {{--src="https://code.jquery.com/jquery-2.2.2.min.js"--}}
            {{--integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI="--}}
        {{--crossorigin="anonymous"></script>--}}

        @yield('styles-head')
        
    </head>
    <body class='skin-blue sidebar-mini'>

    <div class="wrapper">
        <!-- Main Header -->
        @include('painel.includes.barra-topo')

        <!-- Menu -->
        @include('painel.includes.menu')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('title')

                @yield('breadcrumb')
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
    </div>

    @include('painel.includes.footer')

        @yield('scripts-footer')


        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        {{--<script src="{{url('/assets/js/bootstrap.min.js')}}"></script>--}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="{{url('/assets/js/adminLTE/script.js')}}"></script>
        <script src="{{url('/assets/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{url('/assets/plugins/colorpiker/colorpiker.js')}}"></script>
        <script>
            $(function() {

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                //Colorpicker
                $(".my-colorpicker1").colorpicker();
                //color picker with addon
                $(".my-colorpicker2").colorpicker();

            });
        </script>
        <script type="text/javascript" src="{{url('/assets/js/data-picker.js')}}"></script>
    </body>
</html>