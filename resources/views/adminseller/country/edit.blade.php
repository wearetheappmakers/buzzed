@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <input type="hidden" name="id" value="{{ $edit->id }}">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter country name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Phone Code:</label>
            <input type="text" class="form-control" value="{{$edit->phonecode}}" placeholder="Enter phone code" onkeypress="return isNumber(event)" name="phonecode">
        </div>
      
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>