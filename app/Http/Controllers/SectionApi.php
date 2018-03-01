<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Area;
use App\Http\Section;
use DB;

class SectionApi extends Controller
{
    public function index()
    {
        $sections = Section::all();
        $list = array();

        if(count($sections) == 0) {
            $array = array('status' => 1, 'message' => 'Sections not found');
            return response()->json($array);
        }

        foreach ($sections as $section) {
              $array = [
                  'id' => $section->id,
                  'area' => Area::find($section->area),
                  'name' => $section->name,
                  'color' => $section->color
              ];
              array_push($list, $array);
        }

        $array = array('status' => 0, 'sections' => $list);
        return response()->json($array);
    }

    public function show($id)
    {
        try {
            $section = Section::find($id);
            $section = array(
                'id' => $section->id,
                'area' => Area::find($section->area),
                'name' => $section->name,
                'color' => $section->color
            );

            $array = array('status' => 0, 'section' => $section);
            return response()->json($array);
        } catch(\Exception $e) {
            $array = array(
                'status' => 1,
                'message' => 'Section not found'
            );
            return response()->json($array);
        }

    }
}
