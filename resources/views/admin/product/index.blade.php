@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" required>
                    <button class="btn btn-primary" type="submit">Import</button>
            </form>
        </div>

        <div class="col-md-12">
            <a href="{{route('product.create')}}" class="btn btn-primary">Add Product</a>

            <div class="card mt-3">
                <div class="card-header">Product List</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered product-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
  
var table = $('.product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'price', name: 'price'},
            {data: 'stock', name: 'stock'},
            {data: 'category', name: 'category'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    }); 

   $(document).on('click','.delete',function(e){
        const id = $(this).data('id');
        const url = $(this).data('url');
        if(confirm('Are you sure want to delete this?')){
            $.ajax({
                url:url,
                method:'DELETE',
                type:'JSON',
                data:{
                    _token:"{{csrf_token()}}",
                    id:id
                },
                success:function(response){
                    table.ajax.reload(null);
                }
        });
        }
   });
</script>
@endpush