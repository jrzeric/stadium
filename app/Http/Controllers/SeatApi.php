<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Seat;
use App\Http\Section;
use App\Http\Area;

class SeatApi extends Controller
{
    public function index()
    {
        $seats = Seat::all();
        $list = array();

        if(count($seats) == 0) {
            $array = array('status' => 1, 'message' => 'Seats not found');
            return response()->json($array);
        }

        foreach ($seats as $seat) {
            $section = Section::find($seat->section);
            $area = Area::find($section->area);

            $arrayArea = [
                'id' => $area->id,
                'name' => $area->name
            ];

            $arraySection = [
                'id' => $section->id,
                'area' => $arrayArea,
                'name' => $section->name,
                'color' => $section->color
            ];

            $arraySeat = [
                'id' => $seat->id,
                'row' => $seat->row,
                'column' => $seat->column,
                'section' => $arraySection
            ];
            array_push($list, $arraySeat);
        }

        $array = array('status' => 0, 'seats' => $list);
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $seat = Seat::find($id);
            $section = Section::find($seat->section);
            $area = Area::find($section->area);

            $arrayArea = [
                'id' => $area->id,
                'name' => $area->name
            ];

            $arraySection = [
                'id' => $section->id,
                'area' => $arrayArea,
                'name' => $section->name,
                'color' => $section->color
            ];

            $arraySeat = [
                'id' => $seat->id,
                'row' => $seat->row,
                'column' => $seat->column,
                'section' => $arraySection
            ];

            $array = array('status' => 0, 'seat' => $arraySeat);
            return response()->json($array);
        } catch(\Exception $e) {
              $array = array(
                  'status' => 1,
                  'message' => 'Seat not found'
              );
              return response()->json($array);
        }

    }
}
