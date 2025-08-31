<div style="display: flex;">

    <a href="{{route('product.edit',$row->id)}}" class="edit btn btn-primary btn-sm">Edit</a>
    <a href="javascript:void(0)" class="edit btn btn-danger btn-sm delete" data-id="{{$row->id}}" data-url="{{route('product.destroy',$row->id)}}">Delete</a>
</div>