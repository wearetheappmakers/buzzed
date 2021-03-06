@extends('admin.main')

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

    <br>

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="row">

            <div class="col-lg-12">

                <div class="kt-portlet">

                    <div class="kt-portlet__head">

                        <div class="kt-portlet__head-label">

                            <h3 class="kt-portlet__head-title">

                                 {{ $title }}

                            </h3>

                        </div>

                    </div>

                    <form class="kt-form kt-form--label-right add_form" method="post" action="{{$url}}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $edit->id }}">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>First Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter first name" name="fname" value="{{ $edit->fname}}" id="fname" required autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Last Name:</label>
                                    <input type="text" class="form-control" placeholder="Enter last name" value="{{ $edit->lname}}" name="lname" id="lname" required autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>Contact No:</label>
                                    <input type="text" class="form-control" placeholder="Enter contact no" onkeypress="return isNumber(event)" maxlength="10" name="number" id="number" value="{{ $edit->number }}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                 <div class="col-lg-4">
                                    <label>Gender:</label>
                                     <select class="form-control" name="gender">
                                        <option value="1" @if($edit->gender == 1) selected @endif>Male</option>
                                        <option value="2" @if($edit->gender == 2) selected @endif>Female</option>
                                        <option value="3" @if($edit->gender == 3) selected @endif>Other</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label>Birth Date:</label>
                                    <input type="date" class="form-control" placeholder="Enter Birth Date" name="b_date" value="{{ $edit->b_date }}"  id="b_date" required autocomplete="off">
                                </div>

                                <div class="col-lg-4">
                                    <label>Validity</label>
                                    <select class="form-control" name="validity_duration" required="">
                                        <option value="">--Select Validity Duration--</option>
                                        <option value="6" @if($edit->validity_duration == 6) selected @endif>6 Month</option>
                                        <option value="12" @if($edit->validity_duration == 12) selected @endif>1 Year</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-group row">

                                <div class="col-lg-4">
                                    <label>Favourite:</label>
                                    <select class="form-control" name="favourite" id="favourite">
                                        <option value="beer" @if($edit->gender == 'beer') selected @endif >Beer</option>
                                        <option value="whisky" @if($edit->gender == 'whisky') selected @endif >Whisky</option>
                                        <option value="wine" @if($edit->gender == 'wine') selected @endif >Wine</option>
                                        <option value="vodka" @if($edit->gender == 'vodka') selected @endif >Vodka</option>
                                        <option value="rum" @if($edit->gender == 'rum') selected @endif >Rum</option>
                                        <option value="cocktail" @if($edit->gender == 'cocktail') selected @endif >Cocktail</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <label>Membership Amount</label>
                                    <select class="form-control" name="amount" required="">
                                        <option value="">--Select Membership Amount--</option>
                                        @if(!empty($membershipamount))
                                            @foreach($membershipamount as $ma)
                                                <option value="{{ $ma->amount }}" @if($edit->amount == $ma->amount) selected @endif>{{ $ma->amount }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Payment Type</label>
                                    <select class="form-control" data-live-search="true" name="payment_type" required="">
                                        <option value="">--select payment type--</option>
                                        <option value="Cash" @if($edit->payment_type == 'Cash') selected @endif >Cash</option>
                                        <option value="Card" @if($edit->payment_type == 'Card') selected @endif >Card</option>
                                        <option value="UPI" @if($edit->payment_type == 'UPI') selected @endif >UPI</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Upload ID/Proof Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="col-lg-4">
                                     @if($edit->image)
                                        <div class="image_layer">
                                            <div class="image_div">
                                                <a target="_blank"  href="{{ url('storage/uploads/users/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                                                    <img src="{{ url('storage/uploads/users/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                        <label>Status:</label>
                                        <select class="form-control" name="status">
                                            <option value="1" @if($edit->status == 1) selected @endif>Active</option>
                                            <option value="0" @if($edit->status == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                            </div>

                        </div>

                        <div class="kt-portlet__foot">

                            <div class="kt-form__actions">

                                <div class="row">

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8">

                                        <button type="button" class="btn btn-primary submit change_button">Update<i class="la la-spinner change_spin d-none"></i></button>

                                        <a href="{{ $index }}"><button type="button" class="btn btn-secondary">Cancel</button></a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    $(document).ready(function() {

        $(".submit").on("click", function(e) {
            
            e.preventDefault();

            if ($(".add_form").valid()) {
                
                $('.change_button').find('.change_spin').removeClass('d-none');
                $('.change_button').prop('disabled', true);

                $.ajax({

                    type: "POST",

                    url: "{{ $url }}",

                    data: new FormData($('.add_form')[0]),

                    processData: false,

                    contentType: false,

                    success: function(data) {

                        if (data.status === 'success') {
                            
                            window.location = "{{ $index }}";

                            toastr["success"]("{{ $module }} Updated Successfully", "Success");

                            

                        } else if (data.status === 'error') {
                            location.reload();

                            toastr["error"]("Something went wrong", "Error");

                        }

                    },
                    error :function( data ) {
                        console.log(data.status)
                        if(data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors.errors, function (key, value) {
                                console.log(key+ " " +value);
                                $('#'+key).addClass('is-invalid');
                                 $('#'+key).parent().append('<div id="'+key+'-error" class="error invalid-feedback ">'+value+'</div>');
                            });
                                
                            }

                    }

                });

            } else {
                $('.change_button').prop('disabled', false);
                $('.change_button').find('.change_spin').addClass('d-none');
                e.preventDefault();

            }

        });

    });
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>



@stop
