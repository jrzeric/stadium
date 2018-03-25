<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = ['event', 'dateTime', 'seller'];
    public $timestamps = false;
}
