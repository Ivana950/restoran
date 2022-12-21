@extends('admin')

@section('sadrzaj')
<div>
    <v-btn><a href="{{ route('admin.rezervacije.dodaj') }}" class="nav-link">Nova rezervacija</a></v-btn>
    <div>
        <rezervacije></rezervacije>
    </div>
</div>
@endsection