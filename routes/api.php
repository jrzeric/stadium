<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('employees', 'EmployeeController', ['only' => [
    'index'
]]);


Route::resource('events', 'EventApi', ['only' => [
    'index', 'show'
]]);
Route::resource('sections', 'SectionApi', ['only' => [
    'index', 'show'
]]);
Route::resource('seats', 'SeatApi', ['only' => [
    'index', 'show'
]]);
Route::resource('sales', 'SaleApi', ['only' => [
    'index', 'show'
]]);
Route::resource('tickets', 'TicketApi', ['only' => [
    'index', 'show'
]]);
Route::resource('prices', 'PriceApi', ['only' => [
    'index', 'show'
]]);

Route::get('prices/event/{event}/section/{section}', [
    'uses' => 'PriceApi@eventSection'
]);

Route::get('seats/section/{section}', [
    'uses' => 'SeatApi@section'
]);

Route::get('tickets/sale/{sale}/seat/{seat}', [
    'uses' => 'TicketApi@saleSeat'
]);
Route::get('tickets/event/{event}/seat/{seat}', [
    'uses' => 'TicketApi@getTicketsByEventSectionArea'
]);

Route::get('seats/list/get/', [
    'uses' => 'SeatApi@getList2'
]);
Route::post('seats/list/add/id/{id}/price/{price}', [
    'uses' => 'SeatApi@addList2'
]);
Route::get('seats/section/{section}/area/{area}', [
    'uses' => 'SeatApi@getSeatArea'
]);
