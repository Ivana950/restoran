@extends('admin')
@section('sadrzaj')
<div id="app">
    <v-btn><a href="{{ route('admin.meni.index') }}" class="nav-link">Natrag</a></v-btn>
    <dodaj-meni></dodaj-meni>
</div>

@endsection