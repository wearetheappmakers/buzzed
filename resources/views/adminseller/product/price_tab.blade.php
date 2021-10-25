
<style>
    .quantity_input_style form-control {
        width:50%
    }
    </style>
<form method="post" id="product_price_form">
    @csrf
    <div class="col-sm-12">
        <div class="row">
            <div class="clearfix"></div>
            <input type="hidden" name="product_id" value="{{ $product->product_id }}" class="product_id" />

            <?php if ($product->product_type == 4) { ?>
               
                <?php foreach ($product->colors as $color) : ?>

                    <div class="col-sm-4">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{$color->name}}</th>
                                    <th>MRP</th>
                                    <!-- <th>Selling Qunatity</th> -->
                                    <th>Selling Price</th>
                                    <th>Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product->sizes as $size) : ?>
                                    <?php
                                        
                                    ?>
                                    <tr>
                                        <td>{{$size->name}}</td>
                                        <td><input type="text" class="quantity_input_style form-control" name="price[{{$color->id}}][{{$size->id}}]" @if(isset($selected_lot[$color->id][$size->id])) value="{{$selected_lot[$color->id][$size->id] }}"  @endif /></td>
                                       
                                        <td><input type="text" class="quantity_input_style form-control" name="wholesale_price[{{$color->id}}][{{$size->id}}]" value="{{ isset($selected_lot_whole_sale[$color->id][$size->id]) ? $selected_lot_whole_sale[$color->id][$size->id] : '' }}" /></td>

                                        <td>
                                            <div class="form-group">
                                                    <div class="kt-radio-inline">
                                                        <label class="kt-radio">
                                                            <input type="radio" name="tax[{{$color->id}}][{{$size->id}}]" checked value="0"> exclusive
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio">
                                                            <input type="radio" name="tax[{{$color->id}}][{{$size->id}}]" value="1"> inclusive
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php } elseif ($product->product_type == 3) { ?>
                <?php foreach ($product->colors as $color) : ?>
                    <div class="col-sm-4">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{$color->name}}</th>
                                    <th>MRP</th>
                                    <th>Selling Price</th>
                                    <th>Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No size</td>
                                    <td><input type="text"  class="quantity_input_style form-control" name="price[{{$color->id}}][1]" @if(isset($selected_lot[$color->id][1])) value="{{$selected_lot[$color->id][1] }}"  @endif /></td>
                                    <td><input type="text"  class="quantity_input_style form-control" name="wholesale_price[{{$color->id}}][1]" @if(isset($selected_lot_whole_sale[$color->id][1])) value="{{$selected_lot_whole_sale[$color->id][1] }}"  @endif /></td>
                                    <td>
                                        <div class="form-group">
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio">
                                                        <input type="radio" name="tax[{{$color->id}}][1]" checked value="0"> exclusive
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio">
                                                        <input type="radio" name="tax[{{$color->id}}][1]" value="1"> inclusive
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php } elseif ($product->product_type == 2) { ?>
            <div class="col-sm-4">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No color</th>
                                    <th>MRP</th>
                                    <th>Selling Price</th>
                                    <th>Tax</th>
                                </tr>
                            </thead>
                <?php foreach ($product->sizes as $size) : ?>
                   
                            <tbody>
                                <tr>
                                    <td>{{$size->name}}</td>
                                    <td><input type="text" class="quantity_input_style form-control"  name="price[1][{{$size->id}}]" @if(isset($selected_lot[1][$size->id])) value="{{$selected_lot[1][$size->id] }}"  @endif /></td>
                                    <td><input type="text" class="quantity_input_style form-control"  name="wholesale_price[1][{{$size->id}}]" @if(isset($selected_lot_whole_sale[1][$size->id])) value="{{$selected_lot_whole_sale[1][$size->id] }}"  @endif /></td>
                                    <td>
                                        <div class="form-group">
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio">
                                                        <input type="radio" name="tax[1][{{$size->id}}]" checked value="0"> exclusive
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio">
                                                        <input type="radio" name="tax[1][{{$size->id}}]" value="1"> inclusive
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            </tbody>
                        
                <?php endforeach; ?>
                </table>
                    </div>
            <?php } else { ?>
                <div class="col-sm-4">
                    <h5>No color</h5>
                    <table class="table table-striped- table-bordered table-hover">
                        <tr>
                            <td>No size</td>
                            <td><input type="text" class="quantity_input_style form-control" name="price[1][1]" @if(isset($selected_lot[1][1])) value="{{$selected_lot[1][1] }}"  @endif/></td>
                            <td><input type="text" class="quantity_input_style form-control" name="wholesale_price[1][1]" @if(isset($selected_lot_whole_sale[1][1])) value="{{$selected_lot_whole_sale[1][1] }}"  @endif/></td>
                            <td>
                                <div class="form-group">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio">
                                                <input type="radio" name="tax[1][1]" checked value="0"> exclusive
                                                <span></span>
                                            </label>
                                            <label class="kt-radio">
                                                <input type="radio" name="tax[1][1]" value="1"> inclusive
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                        </tr>
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
        <button type="submit" class="btn btn-primary price_update">Update</button>
    </div>
</div>
</form>
