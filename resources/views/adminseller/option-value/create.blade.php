<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
        </div>
        
        <div class="col-lg-4">
            <label>Option</label>
            <select class="form-control" name="option_id" id="option_id">
                <option value="">Select Option</option>
                @foreach($options as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>