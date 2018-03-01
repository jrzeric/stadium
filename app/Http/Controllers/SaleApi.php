<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Sale;
use App\Http\Event;

class SaleApi extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        $list = array();

        if(count($sales) == 0) {
            $array = array('status' => 1, 'message' => 'Sales not found');
            return response()->json($array);
        }

        foreach ($sales as $sale) {
            $event = Event::find($sale->event);
            $arrayEvent = [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'image' => $event->image
            ];

            $arraySale = [
                'id' => $sale->id,
                'event' => $arrayEvent,
                'dateTime' => $sale->dateTime,
                'seller' => $sale->seller
            ];

            array_push($list, $arraySale);
        }

        $array = array('status' => 0, 'sales' => $list);
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $sale = Sale::find($id);
            $event = Event::find($sale->event);

            $sale = array(
                'id' => $sale->id,
                'event' => $event,
                'dateTime' => $sale->dateTime,
                'seller' => $sale->seller
            );

            $array = array('status' => 0, 'sale' => $sale);
            return response()->json($array);
        } catch(\Exception $e) {
            $array = array('status' => 1, 'message' => 'Sale not found');
            return response()->json($array);
        }
    }
}
