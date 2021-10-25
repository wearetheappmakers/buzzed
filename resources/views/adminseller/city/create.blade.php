<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>City Name:</label>
            <input type="text" class="form-control" placeholder="Enter state name" name="name" required>
        </div>
        <div class="col-lg-4">
            <label>Select State:</label>
           <select class="form-control selectpicker" data-live-search="true" name="state_id" required onchange="getCountry($(this).val())">
               <option value="">-- select state --</option>
               @if(!empty($states))
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
               @endif
           </select>
        </div>

        <div class="col-lg-4">
            <label>Country:</label>
            <input type="hidden" name="country_id" id="hccountry_id">
           <select class="form-control" id="ccountry_id" disabled="" required >
               <option value="">-- country --</option>
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

<script type="text/javascript">
  function getCountry(id){
    var countries = <?php echo json_encode($countries); ?>;
    var states = <?php echo json_encode($states); ?>;
    var cid = 0;
      $.each(states,function(key,val){
        if (val.id == id) {
          $('#ccountry_id').val(val.country_id);
          $('#hccountry_id').val(val.country_id);
        }
      });  
  }
</script>