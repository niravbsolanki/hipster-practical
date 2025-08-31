@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{route('product.index')}}" class="btn btn-primary">Product List</a>
            <a href="{{route('order.list')}}" class="btn btn-primary">Order List</a>
            <div class="card mt-2">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        Welcome
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
