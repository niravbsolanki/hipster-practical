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
                    <table class="table table-bordered product-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($customers) > 0)
                               @foreach ($customers as $customer)
                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td class="{{'c_'.$customer->id}} {{ $customer->status =="online" ? 'text-success' : 'text-danger' }}" >{{$customer->status}}</td>
                                </tr>
                            @endforeach
                            @else
                              <tr>
                                 <td colspan="3">Customers not found</td>  
                              </tr> 
                            @endif
                            
                        </tbody>
                    </table>
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
   var socket = new WebSocket('ws://localhost:3000');

   socket.addEventListener('open', () => {
    
    console.log('Client is connected..');
   });
   
   socket.addEventListener('message', (data) => {
    const response = JSON.parse(data.data); 
    $('.c_'+response.customer_id).text(response.status);
    $('.c_'+response.customer_id).removeClass('text-success');
    $('.c_'+response.customer_id).removeClass('text-danger');
    
    if(response.status == 'online'){
        $('.c_'+response.customer_id).addClass('text-success');
    }else{
         $('.c_'+response.customer_id).addClass('text-danger');
    }
    console.log(response);
   });
    </script>
@endpush
