<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id','site_id','tags','note',];

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
