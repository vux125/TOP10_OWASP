@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        @if (isset($username))
            <div class="alert alert-success mt-3" role="alert">
                <strong>Hello </strong>{!! $username !!}
            </div>     
        @endif
    </div>
@endsection