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
            <label>Value:</label>
            <input type="text" class="form-control" value="{{$edit->value}}" placeholder="Enter Value" name="value" required>
        </div>
        <div class="col-lg-4">
            <label>Description:</label>
            <input type="text" class="form-control" value="{{$edit->description}}" placeholder="Enter description" name="description">
        </div>
         </div>
        @include('admin.layout.status_checkbox',array('data' => $edit->status))
   
</div>