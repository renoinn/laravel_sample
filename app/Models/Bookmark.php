<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id','site_id','tags','note',];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeHasTag($query, $tag)
    {
        if (!is_array($tag))
        {
            $tag = [$tag];
        }
        $json = json_encode($tag);
        return $query->whereRaw("JSON_CONTAINS(tags, '".$json."')");
    }
}
