<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

/*Route::get('prueba', function (App\Http\Section $sections) {

    $sections = $sections->where('name', 'Arriba')->get()->toArray();
    return $sections[1];

    return $sections->where('name', 'Arriba')->get();
});*/

/*
Route::get('prueba', function (App\Http\Price $prices, App\Http\Event $events, App\Http\Section $sections) {

    $prices = DB::table('prices')
                ->join('events', 'prices.event', '=', 'events.id')
                ->join('sections', 'prices.section', '=', 'sections.id')
                ->select('events.name as event', 'sections.name as section', 'prices.price as price')
                ->groupBy('events.name', 'sections.name', 'prices.price')
                ->get();

    return $prices;
});*/

/*
Route::get('prueba', function (App\Http\Price $prices, App\Http\Event $events, App\Http\Section $sections) {
    $section = 'Arriba';
    $prices = DB::table('prices')
                ->join('events', 'prices.event', '=', 'events.id')
                ->join('sections', 'prices.section', '=', 'sections.id')
                ->select('prices.event as eventId', 'events.name as event', 'sections.name as section', 'prices.price as price')
                ->where('sections.name', $section)
                ->groupBy('prices.event', 'events.name', 'sections.name', 'prices.price')
                ->get()->toArray();

    return $prices;
});*/

Route::get('prueba', function (App\Http\Price $prices, App\Http\Event $events, App\Http\Section $sections) {
  $prices = DB::table('prices')
              ->join('sections', 'prices.section', '=', 'sections.id')
              ->select('event', 'sections.name', 'price')
              ->where([
                  'prices.event' => '1',
                  'sections.name' => 'Arriba'
                ])
              ->get();
  return $prices;
});


Route::get('employees', [
    'uses' => 'EmployeeController@index',
    'as'   => 'employeeIndex'
]);
Route::get('employees/create', [
    'uses' => 'EmployeeController@create',
    'as'   => 'employeeCreate'
]);
Route::post('employees/store', [
    'uses' => 'EmployeeController@store',
    'as'   => 'employeeStore'
]);
Route::get('employees/{employee}/edit', [
    'uses' => 'EmployeeController@edit',
    'as'   => 'employeeEdit'
]);
Route::post('employees/{employee}', [
    'uses' => 'EmployeeController@update',
    'as'   => 'employeeUpdate'
]);
Route::get('employees/{employee}', [
    'uses' => 'EmployeeController@destroy',
    'as'   => 'employeeDestroy'
]);


Route::get('events', [
    'uses' => 'EventController@index',
    'as'   => 'eventIndex'
]);
Route::get('events/create', [
    'uses' => 'EventController@create',
    'as'   => 'eventCreate'
]);
Route::post('events/store', [
    'uses' => 'EventController@store',
    'as'   => 'eventStore'
]);
Route::get('events/{employee}/edit', [
    'uses' => 'EventController@edit',
    'as'   => 'eventEdit'
]);
Route::post('events/{event}', [
    'uses' => 'EventController@update',
    'as'   => 'eventUpdate'
]);
Route::get('events/{event}', [
    'uses' => 'EventController@destroy',
    'as'   => 'eventDestroy'
]);


Route::get('prices', [
    'uses' => 'PriceController@index',
    'as'   => 'priceIndex'
]);
Route::get('prices/create', [
    'uses' => 'PriceController@create',
    'as'   => 'priceCreate'
]);
Route::post('prices/store', [
    'uses' => 'PriceController@store',
    'as'   => 'priceStore'
]);
Route::get('prices/{price}/edit', [
    'uses' => 'PriceController@edit',
    'as'   => 'priceEdit'
]);
Route::post('prices/{price}', [
    'uses' => 'PriceController@update',
    'as'   => 'priceUpdate'
]);
Route::get('prices/{price}', [
    'uses' => 'PriceController@destroy',
    'as'   => 'priceDestroy'
]);


Route::any('{query}',
  function() { return redirect('/employees'); })
  ->where('query', '.*');
