<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Producto;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('dashboard.calendar.index');
    }

    public function fetchEvents()
    {
        $events = CalendarEvent::with('producto')->get();

        return response()->json($events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title . ' - ' . ucfirst($event->type),
                'start' => $event->start_date,
                'end' => $event->end_date ?? $event->start_date,
                'color' => $event->type === 'siembra' ? '#34D399' : '#60A5FA'
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:siembra,transplante',
            'start_date' => 'required|date',
            'producto_id' => 'required|exists:productos,id',
        ]);

        CalendarEvent::create($request->all());

        return response()->json(['message' => 'Evento creado con éxito']);
    }
}