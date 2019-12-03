<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'list_city';
    public $primaryKey = 'id';
}
