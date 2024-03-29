@extends('layouts.layout')

@section('content')
<div class="container">
    @isset($bookmarks)
        <ul>
        @foreach ($bookmarks as $bookmark)
            <li>
                <dl>
                    <dt><a href="{{ $bookmark->url }}">{{ $bookmark->title }}</a></dt>
                    <dd>
                        @php
                            $tags = json_decode($bookmark->tags, true);
                        @endphp
                        @if ($tags)
                        @foreach ($tags as $tag)
                        <a href="{{ config('app.url') }}/tag/{{ $tag }}">{{ $tag }}</a>
                        @endforeach
                        @endif
                    </dd>
                </dl>
            </li>
        @endforeach
        </ul>
    @endisset
    <div>
        {{ $bookmarks->links() }}
    </div>
</div>
<div><a href="javascript:location.href='{{ config('app.url') }}/bookmarks/create?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)">bookmarklet</a></div>
@endsection
