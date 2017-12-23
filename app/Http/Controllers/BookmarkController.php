<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Site;
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
        $site = Site::where([
            'url' => $url,
        ])->first();

        if($site != null)
        {
            $user = Auth::user();
            $bookmark = $user->bookmarks->where('site_id', $site->id)->first();

            if($bookmark != null)
            {
                return redirect()->route('bookmarks.edit', $bookmark->first());
            }
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
        $site = Site::firstOrCreate(['url' => $request->input('url')], ['title' => $request->input('title')]);

        $bookmark = new Bookmark();
        $bookmark->user()->associate($user);
        $bookmark->site()->associate($site);
        $bookmark->note = $request->input('note');

        $tags = $request->input('tags');
        if(!empty($tags))
        {
            $tags_array = explode(',', trim($tags));
            $bookmark->tags = json_encode($tags_array);
        }

        $bookmark->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
