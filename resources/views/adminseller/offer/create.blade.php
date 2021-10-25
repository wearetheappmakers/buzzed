<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label class="">Image:</label>
            <input type="file" class="form-control" placeholder="Enter image" name="image">
        </div>
        <div class="col-lg-4">
            <label class="">Offer Belongs To Category:</label>
            <select class="form-control" required name="category_slug">
            	<option value="">-- Select Category --</option>
            	@if(!empty($categories))
            		@foreach($categories as $category)
            			<option value="{{ $category->slug }}">{{ $category->name }}</option>
            		@endforeach
            	@else
            		<option value=""></option>
            	@endif
            </select>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
</div>