@extends('admin')

@section('sadrzaj')
<v-btn><a href="{{ route('admin.stolovi.dodaj') }}" class="nav-link">Dodaj stol</a></v-btn>
<div>
    <stolovi></stolovi>
</div>

@endsection