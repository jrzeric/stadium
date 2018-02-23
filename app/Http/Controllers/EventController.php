<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events/index', ['events' => $events]);
    }

    public function create()
    {
        return view('events/create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $date = $request->input('date');
        $description = $request->input('description');
        $image = '0';

        $event = new Event ([
            'name' => $name,
            'date' => $date,
            'description' => $description,
            'image' => $image
        ]);

        $event->save();
        return redirect()->route('eventIndex')->with('status', 'Event created!');
    }

    public function edit($id)
    {
        $event = Event::find($id);
        return view('events/show', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->description = $request->input('description');

        $event->save();
        return redirect()->route('eventIndex')->with('status', 'Changes saved!');
    }

    public function destroy()
    {
        // Vacio
    }
}
