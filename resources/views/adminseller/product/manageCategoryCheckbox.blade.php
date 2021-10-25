@foreach($items as $item)
<div class="col-lg-12">
    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
        <input type="checkbox" name="product[category][]" value="{{ $item->id }}" @if(in_array($item->id, $selected_category)) checked="checked" @endif>
        @for($i=1;$i<=$count;$i++) &nbsp;&nbsp;&nbsp; @endfor {{ $item->name }} <span></span>
    </label>
</div>
<div class="clearfix">
</div>
@if(count($item->items))
@include('adminseller.product.manageCategoryCheckbox',['items' => $item->items,'selected_category'=>$selected_category, 'count' => $count + 2])
@endif
@endforeach