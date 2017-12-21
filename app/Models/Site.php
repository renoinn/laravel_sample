<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['url','title',];

    public function bookmark()
    {
        return $this->hasMany('App\Models\Bookmark');
    }
}
