@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="fullname" value="{{$edit->fullname}}" readonly>
        </div>
        <div class="col-lg-4">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{$edit->email}}" readonly>
        </div>
        <div class="col-lg-4">
            <label>Mobile Number:</label>
            <input type="text" class="form-control" placeholder="Enter Number" name="number" value="{{$edit->number}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4">
            <div class="image_layer">
                <div class="image_div">
                    <a target="_blank"  href="{{ url('storage/uploads/ticket/'.$edit->image) }}" rel="gallery" class="fancybox" title="">
                        <img src="{{ url('storage/uploads/ticket/Tiny/'.$edit->image) }}" class="img-thumbnail" alt="{{ $edit->image }}" />
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <label>Description:</label>
            <textarea class="form-control" placeholder="Enter Description" name="problem_description" readonly>{{$edit->problem_description}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Reply to Ticket</label>
            <textarea name="reply" class="form-control" placeholder="Reply to Ticket">{{$edit->reply}}</textarea>    
        </div>
    </div>
    <input type="hidden" name="is_active" value="1">
    <input type="hidden" name="ticket_number" value="{{$edit->ticket_number}}">
    <input type="hidden" name="image" value="{{$edit->image}}">
</div>
