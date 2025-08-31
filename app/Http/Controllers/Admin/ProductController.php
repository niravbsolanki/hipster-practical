<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductImport;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {

            $data = Product::query();
            return datatables()->eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('image',function($row){
                        $image = asset('default.png');
                        if(isset($row->image) && file_exists('uploads/product/'.$row->image)){
                              $image = asset('uploads/product/'.$row->image);
                        }
                        return '<img src="'.$image.'" height = "80px" width="100px">';
                    })
                    ->addColumn('action', function($row){
                            return view('admin.actions',['row' =>$row])->render();
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->persist());
        return redirect()->route('product.index')->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $data['product'] = Product::find($id);
       return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);
        $product->fill($request->persist())->save();
        return redirect()->route('product.index')->with('success','Product updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $product = Product::find($id);
      $product->delete();

      return response()->json([
        'status' => true,
        'message' => 'Product deleted successfully.'
      ]);
    }

    public function importProduct(Request $request){
        
        $this->validate($request,[
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);
            
        Excel::import(new ProductImport, $request->file('file'));
        return back()->with('success', 'Product import started in background! Please check later!');
    }

}
