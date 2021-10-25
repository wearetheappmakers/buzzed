<div class="modal-header">
    <h5 class="modal-title" id="colorModelLabel">Select Color</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
<form method="post" id="image-color-save-form" action="{{route('admin.product.get_color_popup',['id'=>$id])}}">
@csrf  
<input type="hidden" name="id" value="{{ $id }}">
    <select name="color_id" class="form-control" required>
        <option value="">Select Color</option>
        @foreach($product->colors as $color)
        <option value="{{ $color->id }}" @if($color->id==$color_id) selected='selected' @endif>{{ $color->name }}</option> 
        @endforeach
    </select>
    <button class="btn btn-primary" type="submit" >Save</button>
</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

            
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
     