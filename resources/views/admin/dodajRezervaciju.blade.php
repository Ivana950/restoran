@extends('admin')
@section('sadrzaj')
<div id="app">
    <v-btn><a href="{{ route('admin.rezervacije.index') }}" class="nav-link">Natrag</a></v-btn>
    <dodaj-rezervaciju></dodaj-rezervaciju>
</div>

@endsection