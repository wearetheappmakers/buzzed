
<form method="post" id="discount-form" action="">
    @csrf
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-success apply_discount" id="apply-discount" >Apply</button>
            <button type="button" class="btn btn-danger remove_discount" id="remove-discount" >Remove Discount</button>
        </div>
    </div>
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <th class="text-center" >No</th>
            <th class="text-center" >Discount percentage</th>
            <th class="text-center" >Start date</th>
            <th class="text-center" >End date</th>
            <th>Apply</th>
        </thead>
        <?php //dd($discounts)?>
        <tbody id="discount_rows">
            @foreach ($discounts as $k => $discount)
                <tr id="discount-row-{{ $discount['id'] }}" class="row-move">
                    <td>{{ $k + 1 }}</td>
                    <td class="text-center">{{  $discount['discount_per']  }}%</td>
                    <td class="text-center">{{ $discount['discount_start_date'] }}</td>
                    <td class="text-center">{{ $discount['discount_end_date'] }}</td>
                    <td class="radio-list">
                        <label class="radio">
                        <input type="radio" class="add_discount" name="discount" value="{{ $discount['id'] }}" data-id="{{ $discount['id'] }}" 
                        @if($selected_discount != '' && $selected_discount == $discount['id'] )
                         checked="checked"
                        @endif
                        required>
                        <span></span></label>
                    </td>
                </tr>
            @endforeach
        <tbody>
    </table>
</form>