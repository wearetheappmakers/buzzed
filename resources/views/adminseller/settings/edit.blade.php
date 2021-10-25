@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
        <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" readonly>
        </div>
        <div class="col-lg-4">
            <label>Value:</label>
            <input type="text" class="form-control" value="{{$edit->value}}" placeholder="Enter Value" name="value" required>
        </div>
    </div>
      @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>