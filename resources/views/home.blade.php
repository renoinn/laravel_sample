@extends('layouts.layout')

@section('content')
<div class="container">
    @isset($bookmarks)
        <ul>
        @foreach ($bookmarks as $bookmark)
            <li>
                <dl>
                    <dt><a href="{{ $bookmark->site->url }}">{{ $bookmark->site->title }}</a></dt>
                    <dd>
                    </dd>
                </dl>
            </li>
        @endforeach
        </ul>
    @endisset
</div>
<div><a href="javascript:location.href='{{ config('app.url') }}/bookmarks/create?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)">bookmarklet</a></div>
@endsection
