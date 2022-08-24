@extends('layouts.app')

@section("content")
<h1>wasfa</h1>
<h1>reservation</h1>

{{$reservation->name}}
{{$reservation->chif->name}}
{{$reservation->chif->price}}
<form method="POST" action="{{route('user.payment.store')}}">
    @csrf
    <input type="hidden" name="type" value="reservation">
    <input type="hidden" name="type_id" value="{{$reservation->id}}">
    <input type="hidden" name="price" value="{{$reservation->chif->price}}">
    <select name="type_payment">
        <option>جوال باي</option>
        <option>فيزا كارد</option>
        <option>الدفع عند الاستلام</option>

    </select>
    <button>دفع</button>
</form>
<hr>
@endsection