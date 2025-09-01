@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <a class="btn btn-success" href="{{route('customer.order')}}">My Order</a>
    </div>
    
    <div class="row mt-3">
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
                            <p class="card-text">{{$product->category}} | Price : {{$product->price}} <br> Stock : {{$product->stock}}</p>
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
@push('script')
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
<script>
   var socket = new WebSocket('ws://localhost:3000');
   socket.addEventListener('open', () => {
    
    socket.send(JSON.stringify({
        customer_id: "{{auth('customer')->id()}}",
        status : 'online',
        type : 'customer'
    }));

    console.log('customer is connected..');
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
