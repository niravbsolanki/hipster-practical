<div style="display: flex;">
    @if(isset($order))
    <select name="status" id="status" class="form-control status" data-id="{{$order->id}}">
        <option value="Pending" {{($order->status == "Pending") ? 'selected' : ''}}>Pending</option>
        <option value="Shipped" {{($order->status == "Shipped") ? 'selected' : ''}}>Shipped</option>
        <option value="Delivered" {{($order->status == "Delivered") ? 'selected' : ''}}>Delivered</option>
    </select>
    @else
    <a href="{{route('product.edit',$row->id)}}" class="edit btn btn-primary btn-sm">Edit</a>
    <a href="javascript:void(0)" class="edit btn btn-danger btn-sm delete" data-id="{{$row->id}}" data-url="{{route('product.destroy',$row->id)}}">Delete</a>

    @endif
</div>