@php
$edit = $data['edit'];
@endphp
<div class="kt-portlet__body">
<input type="hidden" name="id" value="{{$edit->id}}">
    <div class="form-group row">
        <div class="col-lg-4">
            <label class="">Name</label>&nbsp;&nbsp;
           
            <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $edit->name }}">
        </div>
        <div class="col-lg-8">
            <label class="">Template</label>
            <textarea class="form-control" name="template" id="template">{!! $edit->template !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-8">
             @include('admin.layout.status_checkbox',array('data' => $edit->status))
        </div>
    </div>
      
</div>

@push('scripts')
<script type="text/javascript">

ClassicEditor
    .create( document.querySelector( '#template' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
</script>
@endpush