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

                                View Affiliatey User Detail

                            </h3>

                        </div>

                        <div class="kt-portlet__head-label">

                            <h3 class="kt-portlet__head-title">

                                <button class="btn btn-brand btn-elevate btn-icon-sm" onclick="window.history.back()">BACK</button>

                            </h3>

                        </div>

                    </div>

                    <form class="kt-form kt-form--label-right add_form">

                        @csrf

                        <div class="kt-portlet__body">

                            <div class="form-group row">

                                <div class="col-lg-4">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" value="{{$refforder->name}}" readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Referral Id:</label>
                                    <input type="text" class="form-control" value="{{$refforder->referral_id}}"  readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Address:</label>
                                    <input type="text" class="form-control" value="{{$refforder->address}}"  readonly>
                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-lg-4">
                                    <label>Email:</label>
                                    <input type="text" class="form-control" value="{{$refforder->email}}" readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Contact:</label>
                                    <input type="text" class="form-control" value="{{$refforder->phone}}"  readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Bank Account Name:</label>
                                    <input type="text" class="form-control" value="{{$refforder->bankAcName}}"  readonly>
                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-lg-4">
                                    <label>Account Number:</label>
                                    <input type="text" class="form-control" value="{{$refforder->bankAcNumber}}" readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>IFSC NO.:</label>
                                    <input type="text" class="form-control" value="{{$refforder->IFSC}}"  readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Bank Name:</label>
                                    <input type="text" class="form-control" value="{{$refforder->bankName}}"  readonly>
                                </div>

                            </div>

                        </div>

                         

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@stop