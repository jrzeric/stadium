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
