@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
       
            <div class="card">
                <div class="card-header">Product Edit</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('product.update',$product->id) }}" enctype="multipart/form-data" name="productForm">
                        @csrf
                        @method('PUT')
                        @include('admin.product.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
