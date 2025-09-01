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
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
<script type="text/javascript">

  var socket = new WebSocket('ws://localhost:3000');

   socket.addEventListener('open', () => {
          console.log('Client is connected..');

          socket.send(JSON.stringify({
                customer_id: "{{auth('customer')->id()}}",
                status : 'online',
                type : 'customer'
        }));

   });
   
   socket.addEventListener('message', (data) => {
      const response = JSON.parse(data.data); 
      if(response.id){
          $('.status_'+response.id).text(response.status);
          console.log('Status Changend Successfully.');
      }
   });

</script>
<script>

firebase.initializeApp({
    apiKey: "AIzaSyC-Jpe28WUNtRma60Ec5M0Lfu5u-5OT_aE",
    authDomain: "practical-844aa.firebaseapp.com",
    databaseURL: "https://practical-844aa-default-rtdb.firebaseio.com",
    projectId: "practical-844aa",
    storageBucket: "practical-844aa.appspot.com", // ✅ fixed
    messagingSenderId: "1053504922767",
    appId: "1:1053504922767:web:feb76b8e2e7f7ad85e3cfa",
    measurementId: "G-XHFCDZKH7L"
});

const messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            messaging.getToken({ vapidKey: "BLkInaEeAsXWTAr-kZnfGin7Wp4GiUQwmnab1PVLviMYFiOsu3-f1AFnq4ZsgcKCRluHMjzBPvf4x_a4av0Pb0g" })
            .then((token) => {
                console.log("FCM Token:", token);

                $.ajax({
                    url: '{{ route("customer.save-token") }}',
                    type: 'POST',
                    data: { token: token },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function () {
                        console.log('Token saved successfully.');
                    },
                    error: function (err) {
                        console.error("Token save error:", err);
                    }
                });
            })
            .catch(err => console.error("FCM Token error:", err));
        } else {
            console.log("Permission not granted for notifications");
        }
    });
}

messaging.onMessage(function(payload) {
    console.log("Message received. ", payload);
    new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon,
    });
});

setTimeout(() => {
    initFirebaseMessagingRegistration();
}, 500);

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then(reg => console.log("Service worker registered", reg))
    .catch(err => console.error("SW registration failed", err));
}
</script>
@endpush