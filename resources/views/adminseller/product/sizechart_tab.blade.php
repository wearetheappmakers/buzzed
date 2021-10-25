
<form method="POST" id="product-sizechart-form" action="">
    @csrf
    <input type="hidden" value="{{$edit->id}}" name="product_id">
    <div class="row">
        <div class="col-lg-6">
            <table class="table table-striped- table-bordered table-hover table-checkable datatable" id="datatable_rows">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Chart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sizechart as $row)
                    <tr>
                        <td>
                            <label class="kt-radio kt-radio--bold kt-radio--brand">
                                <input type="radio" name="sizechart" @if($edit->sizechart == $row->name) checked @endif value="{{$row->name}}">
                                <span></span>
                            </label>
                        </td>
                        <td>
                            <div class="image_layer">
                                <div class="image_div">
                                    <a target="_blank"  href="{{ url('storage/uploads/sizechart/'.$row->name) }}" rel="gallery" class="fancybox" title="">
                                        <img src="{{ url('storage/uploads/sizechart/Tiny/'.$row->name) }}" class="img-thumbnail" alt="{{ $edit->name }}" />
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="submit" class="btn btn-primary sizechart_update" id="sizechart_update">Update</button>
        </div>
    </div>
    
</form>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", "#sizechart_update", function(e) {
            e.preventDefault();
          
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.sizechart_update') }}",
                data: new FormData($('#product-sizechart-form')[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        toastr["success"]("SizeChart Save successfully", "Success");
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