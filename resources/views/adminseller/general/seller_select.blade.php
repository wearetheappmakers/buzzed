@php
if(!isset($seller_id)) {
    $seller_id = '';
}
@endphp
<div class="col-lg-4">
    <label>Seller:</label>
    <select name="seller_id" class="form-control"  required> 
        @php
        $sellers = App\Helpers\CustomeHelper::sellerSelect(true);                
        @endphp
        @foreach($sellers as $k=>$s)
        <option value="{{$k}}" @if($seller_id == $k) selected="selected" @endif> 
            {{$s}}
        </option>
        @endforeach
    </select>
</div>
