@extends('layouts.app')

@section('content')

<body class="sidebar-mini" style="height: auto;">
    <v-row>
        <v-col cols="3">
            <div class="wrapper" id="app">
                <aside class="main-sidebar sidebar-dark-primary elevation-4">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('admin.stolovi.index') }}" class="nav-link">Stolovi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.meni.index') }}" class="nav-link">Meni</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.rezervacije.index') }}" class="nav-link">Rezervacije</a>
                            </li>
                        </ul>
                    </nav>
                </aside>
            </div>
        </v-col>
        <v-col cols="8">
            @yield('sadrzaj')
        </v-col>


    </v-row>

</body>

@endsection