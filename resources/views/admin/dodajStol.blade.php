@extends('admin')
@section('sadrzaj')
<div id="app">
    <v-btn><a href="{{ route('admin.stolovi.index') }}" class="nav-link">Natrag</a></v-btn>
    <dodaj-stol></dodaj-stol>
</div>

@endsection