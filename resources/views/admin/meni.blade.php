@extends('admin')

@section('sadrzaj')
<div>

    <div>
        <v-btn><a href="{{ route('admin.meni.dodaj') }}" class="nav-link">Dodaj meni</a></v-btn>
        <div>
            <meni></meni>
        </div>
    </div>
    @endsection