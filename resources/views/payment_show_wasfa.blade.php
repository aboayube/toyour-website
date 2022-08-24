@extends("layouts.app")
@section("content")
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
<span>{{$data->wasfa->name}}</span>
<span>{{$data->wasfa->price}}</span>
<span>{{$data->countity}}</span>
<form method="POST" action="{{route('admin.payment.store')}}">@csrf
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="type_id" value="{{$data->id}}">
    <input type="hidden" name="price" value="{{$data->wasfa->price}}">
    <input type="hidden" name="status" value="0">

    <button>+</button>
</form>




@endsection