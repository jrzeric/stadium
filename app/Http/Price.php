<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    protected $fillable = ['event', 'section', 'price'];
    public $timestamps = false;
}
