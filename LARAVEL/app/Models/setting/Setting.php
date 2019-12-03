<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'setting';
    public $primaryKey = 'id';
}
