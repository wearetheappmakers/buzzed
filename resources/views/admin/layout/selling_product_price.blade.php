@if(!empty($price))
	@foreach($price as $value)
	<div class="form-group">
		<div class="input-group spriceclass">
		
		<div class="input-group-append">
			<button class="btn btn-secondary" type="button" disabled title="Edit">{{ App\Models\Size::where('id',$value->size_id)->value('name') }}</button>
		</div>
		<input type="text" class="form-control spriceclassvalue" placeholder="Search for..." value="{{ $value->wholesale_price }}" disabled>
		<div class="input-group-append">
			<button class="btn btn-secondary spriceclasseditbtn" type="button" title="Edit" onclick="editsellingprice(this,'{{ $value->id }}','{{ $value->product_id }}')"><i class="fa fa-edit"></i></button>
		</div>
		<div class="input-group-append">
			<button class="btn btn-secondary spriceclasssavebtn" type="button" title="Save" onclick="savesellingprice(this,'{{ $value->id }}','{{ $value->product_id }}')" disabled><i class="fa fa-check"></i></button>
		</div>
		<br>
		</div>
	</div>
	@endforeach
@endif