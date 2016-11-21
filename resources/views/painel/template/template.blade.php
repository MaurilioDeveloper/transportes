<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>{{$titulo or 'Painel M1 Transportes'}}</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{url('/assets/css/bootstrap.min.css')}}">

        <!-- Theme -->
        <link rel="stylesheet" href="{{url('/assets/css/bootstrap-theme.min.css')}}">
        <link rel="stylesheet" href="{{url('/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{url('/assets/css/style2.css')}}">

        <!-- Icon Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- jQuery UI -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
      
        <script
            src="https://code.jquery.com/jquery-2.2.2.min.js"
            integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI="
        crossorigin="anonymous"></script>

        @stack('styles-head')
        
    </head>
    <body class='skin-blue sidebar-mini'>

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

        @include('painel.includes.footer')

        @stack('scripts-footer')
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="{{url('/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{url('/assets/js/script.js')}}"></script>
    </body>
</html>