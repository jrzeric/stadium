<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = ['name', 'date', 'description', 'image'];
    public $timestamps = false;
}
