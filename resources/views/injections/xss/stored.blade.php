@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-4">
        <h2>Product Information</h2>
        <img style="width: 24rem; height:24rem" src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
        <p><strong>Name:</strong> {{ $product->name }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Detail:</strong> {{ $product->detail }}</p>
        <p><strong>Price:</strong> {{ $product->price }}</p>
    </div>

    <div class="mt-4">
        <h2>Comments</h2>
        <form action="/injection/xss/stored/comment" id="commentForm" method="POST">
            @csrf
            <input type="text" name="content" class="form-control" placeholder="Enter your comment" required>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
    <div class="mt-4">
        <h2>All Comments</h2>
        <div id="commentsSection">
            @foreach($comments as $comment)
                <div class="card mb-2">
                    <div class="card-body">
                        <p class="card-text">{!! $comment->content !!}</p>
                        <p class="text-muted">Posted on {!! $comment->created_at !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script>
    $(document).ready(function() {
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/injection/xss/stored/comment',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        $('#commentsSection').prepend(`
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="card-text">${response.comment.content}</p>
                                    <p class="text-muted">Posted on ${response.comment.created_at}</p>
                                </div>
                            </div>
                        `);
                        $('#commentForm')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script> --}}
@endsection