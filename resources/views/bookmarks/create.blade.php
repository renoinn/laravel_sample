@extends('layouts.layout')             
                               
@section('content')            
<form method="POST" action="/bookmarks">
    {{ csrf_field() }}         
    <p>url:<input type="text" name="url" size="80" value="{{ $url }}"></p>
    <p>title:<input type="text" name="title" size="80" value="{{ $title }}"></p>
    <p>note:<textarea name="note"></textarea></p>
    <p>tag: <input type="text" name="tags" size="80"></p>
    <p><input type="submit"></p>    
</form>
@endsection