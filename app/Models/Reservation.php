<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'reservation';
}