@extends('layouts.app')
@section("content")
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
<span>{{$data->name}}</span>
<span>{{$data->chif->price}}</span>
<form method="POST" action="{{route('admin.payment.store')}}">@csrf
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="type_id" value="{{$data->id}}">
    <input type="hidden" name="price" value="{{$data->chif->price}}}">
    <input type="hidden" name="status" value="0">

    <button>+</button>
</form>



@endsection