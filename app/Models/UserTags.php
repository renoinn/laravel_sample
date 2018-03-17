<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTags extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tag', 'count',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    static public function incrementTagCount(\App\User $user, $tag)
    {
        $tagCount = static::firstOrCreate(
            [
                'user_id' => $user->id,
                'tag' => $tag,
            ],
            [
                'tag' => $tag,
                'count' => 0,
            ]
        );

        $tagCount->increment('count');
    }

    static public function decrementTagCount(\App\User $user, $tag)
    {
        $tagCount = static::find([
            'user_id' => $user->id,
            'tag' => $tag,
        ])->first;

        if ($tagCount->count === 1)
        {
            $tagCount->delete();
        } else {
            $tagCount->decrement('count');
        }
    }
}
