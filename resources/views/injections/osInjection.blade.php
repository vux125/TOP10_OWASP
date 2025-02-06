@extends('layouts.app')
@section('content')
    <form action="" method="post">
        @csrf
        <input type="text" name="os" placeholder="domain">
        <input type="submit" >
    </form>
    @if (isset($res))
        <h5>Domain:</h5>
        <p>{{$res}}</p>       
    @elseif (isset($error))
        {{$error}}
    @endif
@endsection
