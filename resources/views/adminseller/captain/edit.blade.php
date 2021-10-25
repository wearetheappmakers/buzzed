@php
$edit = $data['edit'];
$outlet = $data['outlet'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" value="{{$edit->name}}" placeholder="Enter name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Number:</label>
            <input type="text" class="form-control" placeholder="Enter number" onkeypress="return isNumber(event)" maxlength="10" name="number" value="{{$edit->number}}" id="number" required autocomplete="off">
        </div>
        <div class="col-lg-4">
            <label>Outlet:</label>
            <select class="form-control" name="outlet" required="">
                <option value="">-- Select Outlet --</option>
                @if(!empty($outlet))
                    @foreach($outlet as $ol)
                        <option value="{{ $ol->id }}" @if($ol->id == $edit->outlet) selected @endif>{{ $ol->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>