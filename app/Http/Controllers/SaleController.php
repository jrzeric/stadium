<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Event;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $value = session('login');
        if($value) {
            $events = Event::all();
            return view('sales/index', ['events' => $events]);
        } else {
            return redirect()->route('admin.auth.login');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $value = session('login');
        if($value) {
            $data = [
                'event' => $request->input('event'),
                'area' => $request->input('area'),
                'section' => $request->input('section')
            ];
            return view('sales/create', $data);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tickets = $request->input('js');

        foreach ($tickets as $ticket) {
            $eventId = $ticket->title;

            $sale = new Sale ([
                'event' => $firstName,
                'dateTime' => date('Y-m-d'),
                'seller' => session('login')
            ]);

            $sale->save();
        }

        return $array;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
