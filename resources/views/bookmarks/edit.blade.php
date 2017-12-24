@extends('layouts.layout')             
                               
@section('content')            
<form method="POST" action="/bookmarks/{{ $bookmark->id }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <p>url:<input type="text" name="url" size="80" value="{{ $bookmark->url }}"></p>
    <p>title:<input type="text" name="title" size="80" value="{{ $bookmark->title }}"></p>
    <p>note:<textarea name="note">{{ $bookmark->note }}</textarea></p>
    <p>tag: <input type="text" name="tags" size="80" value="{{ $bookmark->tags }}"></p>
    <p><input type="submit"></p>    
</form>
@endsection