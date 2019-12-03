<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'list_country';
    public $primaryKey = 'id';
}
