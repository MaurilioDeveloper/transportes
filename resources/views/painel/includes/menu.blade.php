<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                {{--<img src="{{url("/assets/imgs/user.png")}}" class="img-circle" alt="User Image">--}}
            </div>
            <div class="pull-left info">
{{--                <p>{{ auth()->user()->name }}</p>--}}
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header" style="text-align: center; color: #b8c7ce; font-size: 14px"><i class="fa fa-dashboard"></i> MENU DE NAVEGAÇÃO</li>
            <!-- Optionally, you can add icons to the links -->

            <!-- /.search form -->
            {!! Form::open(['route' => 'pesquisarParceiro', 'class' => 'sidebar-form']) !!}
            {{--        <form class="sidebar-form" method="post" action="{{route('pesquisarParceiro')}}">--}}
            {{--{{csrf_field()}}--}}
            <div class="input-group">
                <input type="text" name="nome" class="form-control" placeholder="Pesquisar Parceiro">
                <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            {{--</form>--}}
            {!! Form::close() !!}


            <li class="treeview">
                <a href="{{route('home')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
            </li>

            <li class="treeview">
                <a href="#"><i class="fa fa-gears"></i> <span>Tipos de ocorrências</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('adicionarParceiro') }}"><i class="fa fa-plus"></i>Novo</a></li>
                    <li><a href="{{ route('adicionarParceiro') }}"><i class="fa fa-search"></i>Ver Todos</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-briefcase"></i> <span>Parceiros</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('adicionarParceiro') }}"><i class="fa fa-plus"></i>Novo</a></li>
                    <li><a href="{{ route('parceiros.index') }}"><i class="fa fa-search"></i>Ver Todos</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-truck"></i> <span>Fretes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('adicionarFrete') }}"><i class="fa fa-plus"></i>Novo</a></li>
                    <li><a href="{{ route('listarFretes') }}"><i class="fa fa-search"></i>Ver Todos</a></li>
                </ul>
            </li>



            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i> <span>Usuários</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('usuarios.create') }}"><i class="fa fa-plus"></i>Novo</a></li>
                    <li><a href="{{ route('usuarios.index') }}"><i class="fa fa-search"></i>Ver Todos</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-plane"></i> <span>Viagens</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('cadastrarViagens') }}"><i class="fa fa-plus"></i>Nova</a></li>
                    <li><a href="{{ route('listaViagens') }}"><i class="fa fa-search"></i>Ver Todas</a></li>
                </ul>
            </li>

            {{--<li class="treeview">--}}
                {{--<a href="#"><i class="fa fa-user"></i> <span>Pessoa</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="treeview">--}}
                        {{--<a href="#"><i class="fa fa-user"></i> <span>Pessoa Física</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                        {{--<ul class="treeview-menu">--}}
                            {{--<li><a href="{{url("/pessoa/create")}}"><i class="fa fa-plus"></i>Novo</a></li>--}}
                            {{--<li><a href=""><i class="fa fa-search"></i>Consultar</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="treeview">--}}
                        {{--<a href="#"><i class="fa fa-briefcase"></i> <span>Pessoa Jurídica</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                        {{--<ul class="treeview-menu">--}}
                            {{--<li><a href="{{url("/pessoa/create")}}"><i class="fa fa-plus"></i>Novo</a></li>--}}
                            {{--<li><a href=""><i class="fa fa-search"></i>Consultar</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class="fa fa-user-plus"></i> <span>Usuário</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href=""><i class="fa fa-plus"></i>Novo</a></li>--}}
                    {{--<li><a href=""><i class="fa fa-search"></i>Consultar</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class="fa fa-user-plus"></i> <span>Dados do Usuário</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href=""><i class="fa fa-user"></i>Meu perfil</a></li>--}}
                    {{--<li><a href=""><i class="fa fa-edit"></i>Editar dados</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
</aside>