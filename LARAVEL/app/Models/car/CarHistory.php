<?php

namespace App\Models\car;

use Illuminate\Database\Eloquent\Model;

class CarHistory extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'car_history';
    public $primaryKey = 'id';
}
