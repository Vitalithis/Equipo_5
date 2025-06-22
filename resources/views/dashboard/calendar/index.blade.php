@extends('layouts.dashboard')

@section('title', 'Calendario de Siembra y Transplante')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Calendario de Siembra y Transplante</h2>

    <div id='calendar'></div>
</div>

@vite('resources/js/calendar.js')
@endsection
