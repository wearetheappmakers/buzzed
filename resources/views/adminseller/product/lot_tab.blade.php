
<style>
    .quantity_input_style {
        width:50%
    }
    </style>
<form method="post" id="product_lot_inventory_form">
    @csrf
    <div class="col-sm-12">
        <div class="row">
            <?php if ($product->product_type == 4) { ?>
               
                <?php foreach ($product->colors as $color) : ?>
                    <div class="col-sm-3">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{$color->name}}</th>
                                    <th>Lot Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product->sizes as $size) : ?>
                                    <tr>
                                        <td>{{$size->name}}</td>
                                    <td><input type="text" class="quantity_input_style"  name="quantity[{{$color->id}}][{{$size->id}}]" @if(isset($selected_lot[$color->id][$size->id])) value="{{$selected_lot[$color->id][$size->id] }}"  @endif /></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php } elseif ($product->product_type == 2) { ?>
           <div class="col-sm-3">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No color</th>
                                    <th>Lot Quantity</th>
                                </tr>
                            </thead>
                <?php foreach ($product->sizes as $size) : ?>
                    
                            <tbody>
                                <tr>
                                    <td>{{$size->name}}</td>
                                    <td><input type="text"  class="quantity_input_style" name="quantity[1][{{$size->id}}]" @if(isset($selected_lot[1][$size->id])) value="{{$selected_lot[1][$size->id] }}"  @endif/></td>
                                </tr>
                            </tbody>
                        
                <?php endforeach; ?>
                </table>
                    </div>
            <?php } ?>
            <div class="clearfix"></div>
        </div>
    </div>
<input type="hidden" id="product_id" class="product_id" name="product_id" value="{{ $product->id }}" >
<input type="hidden" id="is_saved" class="is_saved" name="is_saved" value="1" >
<div class="form-group row">
    <div class="col-lg-4"></div>
    <div class="col-lg-8">
        <button type="submit" class="btn btn-primary lot_inventory_update" >Update</button>
    </div>
</div>
</form>
