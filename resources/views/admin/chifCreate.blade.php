@foreach($services as $service)
{{$service->name}}<br>
{{$service->discription}}<br>
{{$service->price}}<br>
{{$service->day}}<br>

<form method="POST" action="{{route('admin.services.chif.store',$service->id)}}">
    @csrf
    <button>add</button>

</form>
<hr>
@endforeach