@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($product))
        <div class="mt-4">
            <h2>Product Information</h2>
            <img style="width: 24rem; height:24rem" src="{{asset($product->image)}}" class="card-img-top" alt="...">
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Detail:</strong> {{ $product->detail }}</p>
            <p><strong>Price:</strong> {{ $product->price }}</p>
        </div>    
    
    @elseif(isset($list))
    {{-- {{dd($listProduct)}} --}}
                <div class="d-flex flex-wrap">
            @foreach($list as $pd)
                <div class="card m-2" style="width: 18rem;">
                    <img style="width: 18rem; height: 18rem; object-fit: cover;" src="{{ asset($pd->image) }}" class="card-img-top" alt="{{ $pd->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pd->name }}</h5>
                        <p class="card-text">{{ $pd->description }}</p>
                        <h6>{{ $pd->price }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="/injection/sql/in-band/detail" method="get">
                                <input type="text" name="id" value="{{ $pd->id }}" hidden>
                                <button type="submit" class="btn btn-primary">BUY</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h1>Product not found</h1>
    @endif
</div>
@endsection