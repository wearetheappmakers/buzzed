<ul>
@foreach($items as $item)
   <li>
       {{ $item->name }}
       @if(count($item->items))
            @include('adminseller.category.manageChild',['items' => $item->items])
        @endif
   </li>
@endforeach
</ul>