<input type="checkbox" id="topdeals-{{$id}}" href="topdeals-{{$status}}" class="change_status" @if(Auth::guard('vendor')->check()) disabled @endif @if($status==1)? checked @endif value="{{ $id }}">