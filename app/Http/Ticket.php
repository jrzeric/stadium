<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = ['sale', 'seat'];
    public $timestamps = false;
}
