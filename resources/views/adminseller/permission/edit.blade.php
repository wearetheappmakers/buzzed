@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Name:</label>
                <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $edit->name }}" required>
            </div>
            <div class="col-lg-6">
                <label>Email:</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{ $edit->email }}" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Password:</label>
                <input type="text" class="form-control" readonly value="{{ $edit->viewpassword }}">
            </div>
            <div class="col-lg-6">
                <label>Old Passsword</label>
                <input type="text" name="password" class="form-control" placeholder="Enter password">
                <label>If want to update password else remain it as blank !</label>
            </div>
        </div>
        <h3><b>Check to give Access:</b></h3>
        <br>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="products" value="1" @if($edit->products == 1) checked @endif> Product & Product Master
                    <span></span>
                </label>
            </div>
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="inventory" value="1" @if($edit->inventory == 1) checked @endif> Inventory
                    <span></span>
                </label>
            </div>
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="orders" value="1" @if($edit->orders == 1) checked @endif> Orders
                    <span></span>
                </label>
            </div>
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="banner" value="1" @if($edit->banner == 1) checked @endif> Banner
                    <span></span>
                </label>
            </div>
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="blog" value="1" @if($edit->blog == 1) checked @endif> Blog
                    <span></span>
                </label>
            </div>
            <div class="col-lg-2">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                    <input type="checkbox" name="affliate" value="1" @if($edit->affliate == 1) checked @endif> Affliate & Product commission
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</div>