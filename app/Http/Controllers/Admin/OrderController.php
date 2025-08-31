<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $data = Order::query()->with(['customer','product']);
            return datatables()->eloquent($data)
                    ->addColumn('customer',function($row){
                        return $row->customer->name;
                    })
                    ->addColumn('product',function($row){
                        return $row->product->name;
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            return view('admin.actions',['order' =>$row])->render();
                    })
                    ->rawColumns(['customer','product','action'])
                    ->make(true);
        }
        return view('admin.product.order-index');
    }


    /**
     * Display the specified resource.
     */
    public function orderStatus(Request $request)
    {

        $order = Order::find($request->id);
        $order->fill(['status' => $request->status])->save();

        return response()->json([
            'status' => true,
            'message' => 'status changed successfully.'
        ]);
    }

}
