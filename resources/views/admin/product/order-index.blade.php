@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       

        <div class="col-md-12">
            <a href="{{route('admin.dashboard')}}" class="btn btn-primary">Dashboard</a>

            <div class="card mt-3">
                <div class="card-header">Order List</div>

                <div class="card-body">
                    
                    <table class="table table-bordered order-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
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
  
var table = $('.order-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('order.list') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'customer', name: 'customer.name'},
            {data: 'product', name: 'product.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
}); 

  $(document).on('change','.status',function(e){
            const id = $(this).data('id');
            if(confirm('Are you sure want to change this?')){
                $.ajax({
                    url:"{{route('order.status')}}",
                    method:'POST',
                    type:'JSON',
                    data:{
                        _token:"{{csrf_token()}}",
                        id:id,
                        status:$(this).val()
                    },
                    success:function(response){
                        table.ajax.reload(null);
                    }
            });
        }
   });

 
</script>
@endpush