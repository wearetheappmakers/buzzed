@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_5_1">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_category">Category</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_image">Image</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_option">Option</a>
            </li>
        </ul> 
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Name:</label>
                <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{$edit->name}}" required>
                </div>
                <div class="col-lg-4">
                    <label>Description:</label>
                <textarea name="description" class="form-control">{{ $edit->description }}</textarea>
                </div>
                <div class="col-lg-4">
                    <label>Short Description:</label>
                <textarea name="short_description" class="form-control">{{ $edit->short_description}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Product Type:</label>
                    <select class="form-control" name="product_type">
                        <option value="">Select</option>
                        <option value="1">No Color/No Size</option>
                        <option value="2">No Color</option>
                        <option value="3">No Size</option>
                        <option value="4">Both</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>Minimum Quantity:</label>
                <input type="number" class="form-control" name="min_qty" value="{{$edit->min_qty}}" placeholder="Enter Minimum Quantity">
                </div>
                @if(Auth::guard('admin')->check())
                @include('adminseller.general.seller_select')
                @endif
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                   <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                        <input type="checkbox" name="status" value="1"> Status
                        <span></span>
                    </label>
                </div>
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
            </div>
        </div>
        
        <div class="tab-pane" id="kt_tabs_category" role="tabpanel">
            @include('adminseller.product.category_tab', array('product'=> $edit, 'categories'=> $data['categories'])) 								
        </div>
        <div class="tab-pane" id="kt_tabs_image" role="tabpanel">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="">Colour:</label>
                    <input type="text" class="form-control" placeholder="Enter Colour">
                </div>
            </div>									
        </div>
        <div class="tab-pane" id="kt_tabs_option" role="tabpanel">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label class="">Colour:</label>
                    <input type="text" class="form-control" placeholder="Enter Colour">
                </div>
            </div>									
        </div>
    </div>
</div>