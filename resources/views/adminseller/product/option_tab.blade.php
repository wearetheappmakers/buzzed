@php
$selected_option = $edit->optionvalues->toArray();
$selected_option = array_column($selected_option, 'id');
@endphp
<form method="post" id="product-option-form" action="">
    @csrf
    <input type="hidden" value="{{$edit->id}}" name="product_id">
    <div class="form-group row">
        <div class="col-sm-6">
         <table class="table table-striped- table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th>Option value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $key => $option)
                                    <tr>
                                        <td>{{$option->name}}</td>
                                        <td>
                                            <select name="product[option_id][]" class="form-control">                                          
                                               <option value="">Select</option> 
                                                @foreach ($option->option_values as $key => $ov)
                                                    <option value="{{ $ov->id}}" @if(in_array($ov->id, $selected_option)) selected="selected" @endif >{{$ov->name}}</option>
                                                @endforeach
                                         </select>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        </div>

        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary option_update" >Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("submit", "#product-option-form", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.option_update') }}",
                data: new FormData($('#product-option-form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        toastr["success"](data.message, "Success");
                    } else if (data.status == 'error') {
                        toastr["error"]("Something went wrong", "Error");
                    }
                }
            });
            return false;
        });
    });
</script>
@endpush