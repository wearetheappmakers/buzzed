<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" required>
        </div>
        <div class="col-lg-4">
            <label>Parent Id(If want to add sub-category):</label>
            <select  class="form-control"  name="parent_id"  id="parent_id">
                <option value="">Select Parent Category</option>
            @foreach($categories_select as $k=>$c) 
            <option value="{{$k}}">{{html_entity_decode($c)}}</option>
            @endforeach
            </select>
        </div>
      
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Description:</label>
            <textarea class="form-control" placeholder="Enter description" name="description"></textarea>
        </div>
        <div class="col-lg-4">
            <label>Image:</label>
            <input type="file" name="banner_image">
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>