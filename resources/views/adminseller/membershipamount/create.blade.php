<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Amount:</label>
            <input type="text" class="form-control" placeholder="Enter amount" name="amount" onkeypress="return isNumber(event)" required>
        </div>
    </div>
    @include('admin.layout.status_checkbox',array('data' => ""))
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