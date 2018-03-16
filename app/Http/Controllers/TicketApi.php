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

    public function getTicketsByEventSectionArea($event, $seat)
    {
        $ticket = DB::table('tickets')
                    ->join('seats', 'tickets.seat', '=', 'seats.id')
                    ->join('sections', 'seats.section', '=', 'sections.id')
                    ->join('areas', 'sections.area', '=', 'areas.id')
                    ->join('sales', 'tickets.sale', '=', 'sales.id')
                    ->join('events', 'sales.event', '=', 'events.id')
                    ->select('tickets.id as ticketsId', 'tickets.sale as ticketsSale', 'tickets.seat as ticketsSeat',
                        'sales.id as salesId', 'sales.event as salesEvent', 'sales.dateTime as salesDateTime', 'sales.seller as salesSeller',
                        'events.id as eventsId', 'events.name as eventsName', 'events.date as eventsDate', 'events.description as eventsDescription', 'events.image as eventsImage',
                        'seats.id as seatsId', 'seats.row as seatsRow', 'seats.column as seatsColumn', 'seats.section as seatsSection', 'seats.status as seatsStatus',
                        'sections.id as sectionsId', 'sections.area as sectionsArea', 'sections.name as sectionsName', 'sections.color as sectionsColor',
                        'areas.id as areasId', 'areas.name as areasName'
                    )
                    ->where([
                      ['sales.event', $event],
                      ['tickets.seat', $seat]
                    ])->get();

        $array = array('status' => 1, 'message' => 'No ticket found!');

        if (count($ticket) > 0) {
            $area = array(
                'id' => $ticket[0]->areasId,
                'name' => $ticket[0]->areasName
            );

            $section = array(
                'id' => $ticket[0]->sectionsId,
                'area' => $area,
                'name' => $ticket[0]->sectionsName,
                'color' => $ticket[0]->sectionsColor
            );

            $seat = array(
                'id' => $ticket[0]->seatsId,
                'row' => $ticket[0]->seatsRow,
                'column' => $ticket[0]->seatsColumn,
                'section' => $section,
                'status' => $ticket[0]->seatsStatus
            );

            $event = array(
                'id' => $ticket[0]->eventsId,
                'name' => $ticket[0]->eventsName,
                'date' => $ticket[0]->eventsDate,
                'description' => $ticket[0]->eventsDescription,
                'image' => $ticket[0]->eventsImage
            );

            $sale = array(
                'id' => $ticket[0]->salesId,
                'event' => $event,
                'dateTime' => $ticket[0]->salesDateTime,
                'seller' => $ticket[0]->salesSeller
            );

            $ticket = array(
                'id' => $ticket[0]->ticketsId,
                'sale' => $sale,
                'seat' => $seat
            );

            $array = array('status' => 0, 'ticket' => $ticket);
        }

        return response()->json($array);
    }
}
