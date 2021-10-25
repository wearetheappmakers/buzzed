@if(!empty($price))
	@foreach($price as $value)
	<div class="form-group">
		<div class="input-group priceclass">
		
		<div class="input-group-append">
			<button class="btn btn-secondary" type="button" disabled title="Edit">{{ App\Models\Size::where('id',$value->size_id)->value('name') }}</button>
		</div>
		<input type="text" class="form-control priceclassvalue" placeholder="Search for..." value="{{ $value->price }}" disabled>
		<div class="input-group-append">
			<button class="btn btn-secondary priceclasseditbtn" type="button" title="Edit" onclick="editprice(this,'{{ $value->id }}','{{ $value->product_id }}')"><i class="fa fa-edit"></i></button>
		</div>
		<div class="input-group-append">
			<button class="btn btn-secondary priceclasssavebtn" type="button" title="Save" onclick="saveprice(this,'{{ $value->id }}','{{ $value->product_id }}')" disabled><i class="fa fa-check"></i></button>
		</div>
		<br>
		</div>
	</div>
	@endforeach
@endif