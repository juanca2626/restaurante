@extends('landing.layout')

@section('content')
    {{-- <form action="{{ route('daily-dishes') }}" class="mb-8">
        @csrf
        Día: <input type="date" name="date" class="mr-5 py-1 px-1 rounded-sm" value="{{ request()->date ?? now()->format('Y-m-d') }}">
        <button class="action-button" type=submit>Buscar</button>
    </form> --}}
    <daily-menu :menu="{{ $menu }}" :extra-dishes="{{ $extras }}">
    </daily-menu>
@endsection
