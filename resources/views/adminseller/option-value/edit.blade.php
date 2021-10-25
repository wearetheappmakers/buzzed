@php
$edit = $data['edit'];
$options = $data['options'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
    
        <div class="col-lg-4">
            <label>Option</label>
            <select class="form-control" name="option_id">
                @foreach($options as $row)
                    <option @if($edit->option_id == $row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>