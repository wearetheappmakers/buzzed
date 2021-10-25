
<div class="kt-portlet__body">
    <div class="form-group row">
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_5_1">General</a>
            </li>

        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">
            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Name:</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name" required>
                </div>
                <!-- <div class="col-lg-3">
                    <label>Product Code:</label>
                    <input type="text" class="form-control" placeholder="Enter SKU" name="product_code" value="" required>
                </div> -->

                <div class="col-lg-3">
                    <label>SKU:</label>
                    <input type="text" class="form-control" placeholder="Enter SKU" name="sku" value="" required>
                </div>
                <div class="col-lg-3">
                    <label>MOQ:</label>
                    <input type="number" class="form-control" placeholder="Enter MOq" name="moq">
                </div>
                <div class="col-lg-3">
                    <label>Vendor:</label>
                    <select class="form-control" name="vendor_id">
                        <option>-- Select Vendor --</option>
                        @if(!empty($vendors))
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->fname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Description:</label>
                    <textarea name="description" id="description" class="form-control" ></textarea>
                </div>
                <div class="col-lg-3">
                    <label>Select Brand:</label>
                    <select class="form-control" required name="product_brand">
                        <option value="">-- Select Brand --</option>
                        @if(!empty($brands))
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        @else
                            <option value="">No data Available</option>
                        @endif
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>Tax (in %):</label>
                    <input type="text" class="form-control" name="product_tax" maxlength="2" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Product Type:</label>
                    <select class="form-control" name="product_type" required>
                        <option value="">Select</option>
                        <option value="1">No Color/No Size</option>
                        <option value="2">No Color</option>
                        <option value="3">No Size</option>
                        <option value="4" selected>Both</option>
                    </select>
                </div>
                <!-- <div class="col-lg-4">
                    <label>IGST:</label>
                    <input type="number" name="igst" class="form-control">
                </div> -->
                <div class="col-lg-4">
                    <label>Type:</label>
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--brand">
                            <input type="radio" name="type" value="0" checked> Both
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--brand">
                            <input type="radio" name="type" value="1"> Online
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--brand">
                            <input type="radio" name="type" value="2"> Offline
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- <div class="form-group row">
                <div class="col-lg-4">
                   <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="is_home" value="1"> Home
                    <span></span>
                </label>
            </div>
            <div class="col-lg-4">
               <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="is_new" value="1"> New
                <span></span>
            </label>
        </div>
    </div> -->
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>

</div>
</div>
@push('scripts')
<script type="text/javascript">

ClassicEditor
    .create( document.querySelector( '#description' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
</script>
@endpush