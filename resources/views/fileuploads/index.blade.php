@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Image</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Choose Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@if (isset($error))
    <h5 >
        {{ $error }}
    </h5>
@else
    @if (isset($success))
        <div class="container">
            <h5>{{$success}}</h5>
            <h5>This url image: {{$url}}</h5>
        </div>
    @endif
    
@endif
@endsection