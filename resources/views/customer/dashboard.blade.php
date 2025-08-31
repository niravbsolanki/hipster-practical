@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="{{ route('customer.search') }}" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Searching ..." required>
        <button class="btn btn-primary mt-3" type="submit">Search</button>               
        </form>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            
            <div class="card">

                <div class="card-header">Product List</div>

                <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                    </div>
                @endif
                 <div class="row">
                  @foreach ($products as $product)
                        <div class="col-3 mt-3">
                        <div class="card" style="width: 18rem;">
                            @if (isset($product->image) && file_exists('uploads/product/'.$product->image))
                            <img src="{{asset('uploads/product/'.$product->image)}}" class="card-img-top" alt="...">
                            @else
                            <img src="{{asset('default.png')}}" class="card-img-top" alt="...">
                            @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name ?? ''}}</h5>
                            <p class="card-text">Price : {{$product->price}} | Stock : {{$product->stock}}</p>
                            <p class="card-text">{{$product->description}}</p>
                            
                            <a href="{{route('customer.place.order',$product->id)}}" class="btn btn-primary">Place Order</a>
                        </div>
                        </div>
                        </div>
                  @endforeach
                 </div>
                 <div class="paginate mt-5">
                     {{ $products->links() }}
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
