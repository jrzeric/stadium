<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Event;

class EventApi extends Controller
{
    public function index()
    {
        $events = Event::all()->toArray();

        if(count($events) == 0) {
            $array = array('status' => 1, 'message' => 'Events not found');
            return response()->json($array);
        }

        $array = array(
            'status' => 0,
            'events' => $events
        );
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $event = Event::find($id)->toArray();
            $array = array(
                'status' => 0,
                'event' => $event
            );
            return response()->json($array);
        } catch(\Exception $e) {
            $array = array(
                'status' => 1,
                'message' => 'Event not found'
            );
            return response()->json($array);
        }

    }
}
