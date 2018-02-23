<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Price;
use App\Http\Event;
use App\Http\Section;
use App\Http\Area;
use DB;

class PriceController extends Controller
{
    public function index()
    {
        $prices = DB::table('prices')
                    ->join('events', 'prices.event', '=', 'events.id')
                    ->join('sections', 'prices.section', '=', 'sections.id')
                    ->select('events.name as event', 'sections.name as section', 'prices.price as price')
                    ->groupBy('events.name', 'sections.name', 'prices.price')
                    ->get();

        return view('prices/index', ['prices' => $prices]);
    }

    public function create()
    {
        $events = Event::all();
        $sections = Section::all();

        return view('prices/create')->with('events', $events)->with('sections', $sections);
    }

    public function store(Request $request)
    {
        $event = $request->input('event');
        $topPrice = $request->input('priceTop');
        $middlePrice = $request->input('priceMiddle');
        $bottomPrice = $request->input('priceBottom');

        $topSections = Section::where('name', 'Arriba')->get();
        $middleSections = Section::where('name', 'Medio')->get();
        $bottomSections = Section::where('name', 'Abajo')->get();

        for ($i = 0; $i < count($topSections); $i++) {
            $price = new Price([
                'event' => $event,
                'section' => $topSections[$i]->id,
                'price' => $topPrice
            ]);
            $price->save();
        }


        for ($i = 0; $i < count($middleSections); $i++) {
            $price = new Price([
                'event' => $event,
                'section' => $middleSections[$i]->id,
                'price' => $middlePrice
            ]);
            $price->save();
        }


        for ($i = 0; $i < count($bottomSections); $i++) {
            $price = new Price([
                'event' => $event,
                'section' => $bottomSections[$i]->id,
                'price' => $bottomPrice
            ]);
            $price->save();
        }


        return redirect()->route('priceIndex')->with('status', 'Prices stored!');
    }

    public function edit($section)
    {
        $price = DB::table('prices')
                      ->join('events', 'prices.event', '=', 'events.id')
                      ->join('sections', 'prices.section', '=', 'sections.id')
                      ->select('prices.event as eventId', 'events.name as event', 'sections.name as section', 'prices.price as price')
                      ->where('sections.name', $section)
                      ->groupBy('prices.event', 'events.name', 'sections.name', 'prices.price')
                      ->first();

        return view('prices/show', ['price' => $price]);
    }

    public function update(Request $request, $section)
    {
        //$price = Price::find($id);

        $prices = DB::table('prices')
                    ->join('sections', 'prices.section', '=', 'sections.id')
                    ->select('id', 'event', 'prices.section', 'price')
                    ->where([
                        'prices.event' => $request->input('event'),
                        'sections.name' => $section
                      ])
                    ->get();

        foreach ($prices as $price) {
            $price = Price::where('idyyy');
            $price->event => $prices[$i]->event,
            $price->section => $prices[$i]->section,
            $price->price => $request->input('price')

            $price->save();
        }

        return redirect()->route('priceIndex')->with('status', 'Changes saved!');
    }

    public function destroy()
    {
        // Vacio
    }
}
