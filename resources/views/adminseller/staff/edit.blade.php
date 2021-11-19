@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $edit->name }}" required>
        </div>
        <div class="col-lg-4">
            <label>Contact No:</label>
            <input type="text" class="form-control" placeholder="Enter contact no" value="{{ $edit->number }}" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Enter email" value="{{ $edit->email }}" name="email" id="email" required autocomplete="off" required="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Gender:</label>
             <select class="form-control" name="gender">
                <option value="1" @if($edit->gender == 1) selected @endif>Male</option>
                <option value="2" @if($edit->gender == 2) selected @endif>Female</option>
                <option value="3" @if($edit->gender == 3) selected @endif>Other</option>
            </select>
        </div>
        <div class="col-lg-4">
            <label>Role:</label>
             <select class="form-control" name="role">
                <option value="1" @if($edit->role == 1) selected @endif>Operations Manager</option>
                <option value="2" @if($edit->role == 2) selected @endif>Waiters</option>
            </select>
        </div>
        <div class="col-lg-4">
            <label>Password:</label>
            <input type="password" class="form-control" value="{{ $edit->spassword }}" placeholder="Enter password" name="spassword" id="spassword" required autocomplete="off">
        </div>
</div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))