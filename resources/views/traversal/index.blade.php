@extends('layouts.app')

@section('content')
    
    @php
        include resource_path('views/traversal/' . $view );
    @endphp
    <form action="/traversal" method="get">
        <input type="hidden" name="view" value="home.blade.php">
        <button type="submit">HOME</button>
    </form>
    <form action="/traversal" method="get">
        <input type="hidden" name="view" value="login.blade.php">
        <button type="submit">LOGIN</button>
    </form>
    <form action="/traversal" method="get">
        <input type="hidden" name="view" value="register.blade.php">
        <button type="submit">REGISTER</button>
    </form>
@endsection