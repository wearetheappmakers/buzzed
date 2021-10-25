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
            <label>Label:</label>
            <input type="text" class="form-control" value="{{$edit->label}}" placeholder="Enter label" name="label" required>
        </div>
        <div class="col-lg-4">
            <label>Description:</label>
            <input type="text" class="form-control" value="{{$edit->description}}" placeholder="Enter description" name="description" required>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => $edit->status))
    <!-- <div class="form-group row">
        <div class="col-lg-4">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                <input type="checkbox" name="show_on_timeline" @if($edit->show_on_timeline == 1) checked @endif value="1"> show_on_timeline
                <span></span>
            </label>
        </div>
    </div> -->
</div>