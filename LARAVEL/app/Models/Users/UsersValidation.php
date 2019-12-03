<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UsersValidation extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'users_validation';
    public $primaryKey = 'id';
}
