<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'employee';
    protected $fillable = ['employee', 'profile', 'email', 'password', 'status', 'created_at', 'updated_at'];
    public $timestamps = false;
}
