<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Area;
use App\Http\Event;
use App\Http\Sale;
use App\Http\Seat;
use App\Http\Section;
use App\Http\Ticket;
use DB;

class TicketApi extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        $list = array();

        if(count($tickets) == 0) {
            $array = array('status' => 1, 'message' => 'Tickets not found');
            return response()->json($array);
        }

        foreach ($tickets as $ticket) {
            $sale = Sale::find($ticket->sale);
            $event = Event::find($sale->event);

            $seat = Seat::find($ticket->seat);
            $section = Section::find($seat->section);
            $area = Area::find($section->area);

            $area = array(
                'id' => $area->id,
                'name' => $area->name
            );

            $section = array(
                'id' => $section->id,
                'area' => $area,
                'name' => $section->name,
                'color' => $section->color
            );

            $seat = array(
                'id' => $seat->id,
                'row' => $seat->row,
                'column' => $seat->column,
                'section' => $section,
                'status' => $seat->status
            );

            $event = array(
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'image' => $event->image
            );

            $sale = array(
                'id' => $sale->id,
                'event' => $event,
                'dateTime' => $sale->dateTime,
                'seller' => $sale->seller
            );

            $ticket = array(
                'id' => $ticket->id,
                'sale' => $sale,
                'seat' => $seat
            );

            array_push($list, $ticket);
        }

        $array = array('status' => 0, 'tickets' => $list);
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $ticket = Ticket::find($id);

            $sale = Sale::find($ticket->sale);
            $event = Event::find($sale->event);

            $seat = Seat::find($ticket->seat);
            $section = Section::find($seat->section);
            $area = Area::find($section->area);

            $area = array(
                'id' => $area->id,
                'name' => $area->name
            );

            $section = array(
                'id' => $section->id,
                'area' => $area,
                'name' => $section->name,
                'color' => $section->color
            );

            $seat = array(
                'id' => $seat->id,
                'row' => $seat->row,
                'column' => $seat->column,
                'section' => $section,
                'status' => $seat->status
            );

            $event = array(
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'image' => $event->image
            );

            $sale = array(
                'id' => $sale->id,
                'event' => $event,
                'dateTime' => $sale->dateTime,
                'seller' => $sale->seller
            );

            $ticket = array(
                'id' => $ticket->id,
                'sale' => $sale,
                'seat' => $seat
            );

            $array = array('status' => 0, 'tickets' => $ticket);
            return response()->json($array);
        } catch(\Exception $e) {
            $array = array('status' => 1, 'message' => 'Ticket not found');
            return response()->json($array);
        }
    }

    public function saleSeat($sale, $seat)
    {
        try {
            $tickets = DB::table('tickets')
                        ->select('id', 'sale', 'seat')
                        ->where([
                            'sale' =>$sale,
                            'seat' =>$seat,
                        ])
                        ->get();

            $array = array('status' => 0, 'tickets' => $tickets);
            return response()->json($array);
        } catch(\Exception $e) {
            $array = array('status' => 1, 'message' => 'Ticket not found');
            return response()->json($array);
        }
    }
}
