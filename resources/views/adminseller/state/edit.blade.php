@php
$edit = $data['edit'];
$countries = $data['countries'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <input type="hidden" name="id" value="{{ $edit->id }}">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter state name" name="name" value="{{ $edit->name }}" required>
        </div>
        <div class="col-lg-4">
            <label>Select Country:</label>
           <select class="form-control" name="country_id" required>
               <option value="">-- select country --</option>
               @if(!empty($countries))
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" @if($edit->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach
               @endif
           </select>
        </div>

    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>