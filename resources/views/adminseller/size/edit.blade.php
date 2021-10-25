@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Code:</label>
            <input type="text" class="form-control" value="{{$edit->code}}" placeholder="Enter color code" name="code" required>
        </div>
   
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>