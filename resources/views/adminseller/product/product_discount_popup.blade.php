<div class="modal-header">
    <h5 class="modal-title" id="colorModelLabel">Select Discount</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
<form method="post" id="image-discount-save-form" action="{{route('admin.product.get_discount_popup')}}">
@csrf  
    <a>hello</a>
    <button class="btn btn-primary" type="submit" >Save</button>
</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
