<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'notification';
    public $primaryKey = 'id';
}
