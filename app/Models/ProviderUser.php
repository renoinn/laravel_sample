<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderUser extends Model
{
    protected $fillable = ['provider_user_id','email','name',
        'nickname','avatar','token','token_secret',];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
