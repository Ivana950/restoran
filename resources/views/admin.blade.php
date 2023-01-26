@extends('layouts.app')

@section('content')

<body class="sidebar-mini" style="height: auto;">
    <v-row>
        <v-col cols="3" class="pr-0 pb-0">
            <aside class="main-sidebar sidebar-dark-primary mt-1 pt-8">
                <nav>
                    <h4 class="pl-7 mb-10 blue--text">Administracija <v-icon color="blue">mdi-account-tie</v-icon></h3>
                        <ul class="nav nav-pills nav-sidebar flex-column pa-0" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="aside-nav-item">
                                <a href="{{ route('admin.stolovi.index') }}" class="nav-link">Stolovi</a>
                            </li>
                            <li class="aside-nav-item">
                                <a href="{{ route('admin.meni.index') }}" class="nav-link">Meni</a>
                            </li>
                            <li class="aside-nav-item">
                                <a href="{{ route('admin.rezervacije.index') }}" class="nav-link">Rezervacije</a>
                            </li>
                        </ul>
                </nav>
            </aside>
        </v-col>
        <v-col cols="9">
            @yield('sadrzaj')
        </v-col>


    </v-row>

</body>

@endsection