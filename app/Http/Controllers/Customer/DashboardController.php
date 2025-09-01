<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $data['products'] = Product::where('stock','>',0)->paginate(20);
        return view('customer.dashboard',$data);
    }

    public function logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }

    public function placeOreder($id){
        $product = Product::find($id);
        Order::create(['customer_id'=>auth('customer')->id(),'product_id'=>$id]);
        if($product->stock == 0){
             return redirect()->route('customer.dashboard')->with('success','Product out of stock.');
        }
        $product->fill(['stock' => $product->stock - 1])->save();
        return redirect()->route('customer.dashboard')->with('success','Order placed successfully.');
    }

    public function searchProduct(Request $request){
        $data['products'] = Product::where('stock','>',0)
        ->where(function($q) use($request){
              $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%');
        })->paginate(20);

          return view('customer.dashboard',$data);
    }

    public function myOrder(){
        $data['orders'] = Order::where('customer_id',auth('customer')->id())->paginate(20);
        return view('customer.order',$data);
    }
}
