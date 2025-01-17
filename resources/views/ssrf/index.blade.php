@extends('layouts.app')
@section('content')
    <form action="" method="get">
        <label for="">Input url image: </label>
        <input type="text" name="url" id="url">
        <input type="submit" value="Submit">
    </form>
    @if(isset($response))
        
        <img src="{!! $response !!}" alt="">
    @endif
@endsection