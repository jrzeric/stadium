<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Price;
use App\Http\Event;
use App\Http\Section;
use App\Http\Area;

class PriceApi extends Controller
{
    public function index()
    {
        $prices = Price::all();
        $list = array();

        if(count($prices) == 0) {
            $array = array('status' => 1, 'message' => 'Prices not found');
            return response()->json($array);
        }

        foreach ($prices as $price) {
            $event = Event::find($price->event);

            $section = Section::find($price->section);
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

            $event = array(
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'image' => $event->image
            );

            $price = array(
                'id' => $price->id,
                'event' => $event,
                'section' => $section,
                'price' => $price->price
            );

            array_push($list, $price);
        }

        $array = array('status' => 0, 'prices' => $list);
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $price = Price::find($id);

            $event = Event::find($price->event);

            $section = Section::find($price->section);
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

            $event = array(
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'image' => $event->image
            );

            $price = array(
                'id' => $price->id,
                'event' => $event,
                'section' => $section,
                'price' => $price->price
            );

            $array = array('status' => 0, 'price' => $price);
            return response()->json($array);
        } catch(\Exception $e) {
          $array = array('status' => 1, 'message' => 'Price not found');
          return response()->json($array);
        }
    }
}
