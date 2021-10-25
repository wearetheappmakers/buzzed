<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>State Name:</label>
            <input type="text" class="form-control" placeholder="Enter state name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Select Country:</label>
           <select class="form-control" name="country_id" required>
               <option value="">-- select country --</option>
               @if(!empty($countries))
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
               @endif
           </select>
        </div>

    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>