<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'list_brand';
    public $primaryKey = 'id';
}
