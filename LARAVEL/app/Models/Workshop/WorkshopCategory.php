<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class WorkshopCategory extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'workshop_categories';
    public $primaryKey = 'id';
}
