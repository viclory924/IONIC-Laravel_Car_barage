<?php

namespace App\Models\car;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'car';
    public $primaryKey = 'id';
}
