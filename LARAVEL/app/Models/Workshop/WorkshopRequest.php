<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class WorkshopRequest extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'workshop_request';
    public $primaryKey = 'id';
}
