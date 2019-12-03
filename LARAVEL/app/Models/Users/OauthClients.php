<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class OauthClients extends Model
{
    protected $guarded = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $table = 'oauth_clients';
    public $primaryKey = 'id';
}
