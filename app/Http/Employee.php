<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['firstName', 'lastname', 'hired'];
    public $timestamps = false;
}
