@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       

        <div class="col-md-12">
            <a href="{{route('customer.dashboard')}}" class="btn btn-primary">Dashboard</a>

            <div class="card mt-3">
                <div class="card-header">My Order</div>

                <div class="card-body">
                    
                    <table class="table table-bordered order-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($orders) > 0)
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{$order->id}}
                                    </td>
                                    <td>
                                        {{$order->product->name}}
                                    </td>
                                    <td>
                                        {{$order->product->price}}
                                    </td>
                                    <td class="status_{{$order->id}}">
                                        {{$order->status}}
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">Order not available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
          
                   <div class="paginate">
                        {{ $orders->links() }}
                   </div>
          
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">

  var socket = new WebSocket('ws://localhost:3000');

   socket.addEventListener('open', () => {
          console.log('Client is connected..');
   });
   
   socket.addEventListener('message', (data) => {
      const response = JSON.parse(data.data); 
      $('.status_'+response.id).text(response.status);
      console.log('Status Changend Successfully.');
   });

</script>
@endpush