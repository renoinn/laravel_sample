<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list($tag)
    {
        $user = Auth::user();

        $bookmarks = Bookmark::where('user_id', $user->id)->orderBy('created_at', 'desc')->hasTag($tag)->paginate(20);
        return view('home', [
            'bookmarks' => $bookmarks
        ]);
    }
}
