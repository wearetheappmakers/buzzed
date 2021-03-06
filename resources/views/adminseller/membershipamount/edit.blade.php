@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Amount:</label>
            <input type="text" class="form-control" value="{{$edit->amount}}" placeholder="Enter amount" name="amount" onkeypress="return isNumber(event)" required>
        </div>
        <div class="col-lg-4">
            <label>Validity</label>
            <select class="form-control" name="valid_time" required="">
                <option value="">--Select Validity Duration--</option>
                <option value="6" @if($edit->valid_time == 6) selected @endif>6 Month</option>
                <option value="12" @if($edit->valid_time == 12) selected @endif>1 Year</option>
            </select>
        </div>
    </div>
     @include('admin.layout.status_checkbox',array('data' => $edit->status))
</div>

<script type="text/javascript">
	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>