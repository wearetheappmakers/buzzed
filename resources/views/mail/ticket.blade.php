<h1>Name: {{$fullname}}</h1>
<h3>Number: {{$number}}</h3>
<h3>Ticket Number: {{$ticket_number}}</h3>
<a><b>Problem Description:</b> {{$problem_description}}</a>
@if(!empty($reply))
<br><a><b>Response:</b> {{$reply}}</a>
@endif
@if(!empty($image))
<br><a href="{{ url('storage/uploads/ticket/'.$image)}}" download>Download Image</a>
<br><img src="{{ url('storage/uploads/ticket/Small/'.$image) }}" download/>
@endif