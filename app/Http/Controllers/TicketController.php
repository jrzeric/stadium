<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Event;

class TicketController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('tickets/index', ['events' => $events]);
    }
}
