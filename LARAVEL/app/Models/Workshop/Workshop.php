<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'workshop';
    public $primaryKey = 'id';
}
