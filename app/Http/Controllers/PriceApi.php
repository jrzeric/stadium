<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Price;
use App\Http\Event;
use App\Http\Section;
use App\Http\Area;
use DB;

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

    public function eventSection($event, $section)
    {
        $price = DB::table('prices')
                    ->join('sections', 'prices.section', '=', 'sections.id')
                    ->join('areas', 'sections.area', '=', 'areas.id')
                    ->join('events', 'prices.event', '=', 'events.id')
                    ->select('prices.id as pricesId', 'prices.event as pricesEvent', 'prices.section as pricesSection', 'prices.price as pricesPrice',
                        'events.id as eventsId', 'events.name as eventsName', 'events.date as eventsDate', 'events.description as eventsDescription', 'events.image as eventsImage',
                        'sections.id as sectionsId', 'sections.area as sectionsArea', 'sections.name as sectionsName', 'sections.color as sectionsColor',
                        'areas.id as areasId', 'areas.name as areasName'
                    )
                    ->where([
                      ['prices.event', $event],
                      ['prices.section', $section],
                    ])->get();

        $array = array('status' => 1, 'message' => 'No prices found!');

        if (count($price) == 1) {
            try {
                $area = array(
                    'id' => $price[0]->areasId,
                    'name' => $price[0]->areasName
                );

                $section = array(
                    'id' => $price[0]->sectionsId,
                    'area' => $area,
                    'name' => $price[0]->sectionsName,
                    'color' => $price[0]->sectionsColor
                );

                $event = array(
                    'id' => $price[0]->eventsId,
                    'name' => $price[0]->eventsName,
                    'date' => $price[0]->eventsDate,
                    'description' => $price[0]->eventsDescription,
                    'image' => $price[0]->eventsImage,
                );

                $price = array(
                    'id' => $price[0]->pricesId,
                    'event' => $event,
                    'section' => $section,
                    'price' => $price[0]->pricesPrice
                );

                $array = array('status' => 0, 'price' => $price);
                return response()->json($array);
            } catch(\Exception $e) {
                $array = array('status' => 1, 'message' => 'Price not found');
                return response()->json($array);
            }
        }
    }
}
