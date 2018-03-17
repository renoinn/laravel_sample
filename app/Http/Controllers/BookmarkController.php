<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\UserTags;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $url = $request->query('url');
        $title = $request->query('title');

        $user = Auth::user();
        $bookmark = $user->bookmarks->where('url', $url)->first();

        if($bookmark != null)
        {
            return redirect()->route('bookmarks.edit', $bookmark);
        }

        return view('bookmarks.create', [
            'url' => $url,
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $bookmark = new Bookmark();
        $bookmark->user()->associate($user);
        $bookmark->url = $request->input('url');
        $bookmark->title = $request->input('title');
        $bookmark->note = $request->input('note');

        $tags = $request->input('tags');
        $tags_array = [];
        if (!empty($tags))
        {
            $tags_array = explode(' ', trim($tags));
            $bookmark->tags = json_encode($tags_array);
        }


        \DB::transaction(function() use($user, $bookmark, $tags_array) {
            $bookmark->save();

            if (!empty($tags_array)) {
                foreach ($tags_array as $tag) {
                    UserTags::incrementTagCount($user, $tag);
                }
            }
        });
        header('location: '.$request->input('url'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        return view('bookmarks.edit', [
            'bookmark' => $bookmark,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        $bookmark->url = $request->input('url');
        $bookmark->title = $request->input('title');
        $bookmark->note = $request->input('note');

        $tags = $request->input('tags');
        $tags_array = [];
        $old_tags_array = json_decode($bookmark->tags, true);
        if(!empty($tags))
        {
            $tags_array = explode(',', trim($tags));
            $bookmark->tags = json_encode($tags_array);
        }

        \DB::transaction(function() use($bookmark, $tags_array, $old_tags_array) {
            $bookmark->save();

            $user = Auth::user();
            $intersect = array_intersect($tags_array, $old_tags_array);

            foreach ($tags_array as $tag) {
                if (in_array($tag, $intersect))
                {
                    continue;
                }

                UserTags::incrementTagCount($user, $tag);
            }

            foreach ($old_tags_array as $tag) {
                if (in_array($tag, $intersect))
                {
                    continue;
                }

                UserTags::decrementTagCount($user, $tag);
            }
        });
        
        header('location: '.$request->input('url'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();
        return redirect('home');
    }
}
