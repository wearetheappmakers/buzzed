
@if($image)
    <a target="_blank"  href="{{ url('storage/uploads/'. $folder_name.'/'.$image) }}" rel="gallery" class="fancybox" title="">
        <img src="{{ url('storage/uploads/'. $folder_name.'/Tiny/'.$image) }}" width="50px" class="img-thumbnail" alt="{{ $image }}" />
    </a>
@else
<a>-</a>
@endif