  @php
  $image = $image;
  @endphp
  <div id="row-<?php echo $image->id ?>" class="col-sm-2 item row-move">
      <div class="image_layer text-center">
          <div class="">

              @include('admin.layout.singlecheckbox',array('status'=>$image->status,'id'=>$image->id))
              <!-- <a href="del-{{ $image->id }}" class="delete delete_row">
                  <i class="fa fa-times"></i>
              </a> -->
              <a style="background: skyblue;" class="btn btn-sm btn-clean btn-icon btn-icon-md handle" title="Drag Image" href="javascript:void(0)">
                  <i style="color: white;" class="fas fa-arrows-alt">
                  <!-- <i style="color: white;" class="fas fa-hand-point-up"> -->
                  </i>
              </a>
              <button style="background: red;" title="Delete" data-id="{{$image->id }}" title="Delete Image" class="btn btn-sm btn-clean btn-icon btn-icon-md delete-record">
                  <i style="color: white;" class="la la-trash">
                  </i>
              </button>
          </div>
          <div class="image_div">
              <a href="{{ $image->image }}" rel="gallery" class="fancybox" title="">
                  <img src="{{ $image->image }}" class="img-thumbnail" alt="{{ $image->image }}" />
              </a>
          </div>
        <button class="color_popup" id="color_popup{{ $image->id }}" data-href="{{route('admin.product.get_color_popup',['id'=>$image->id])}}" data-color_id="{{$image->color_id}}">
        @if($image->colors)
            {{ $image->colors->name }}
        @else
            Select Color
        @endif
        </button>
      </div>
  </div>

  @push('scripts')
  @endpush