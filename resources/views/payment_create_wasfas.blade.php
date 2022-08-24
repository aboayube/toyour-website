@extends('layouts.app')

@section("content")
@php
$pric=0;
@endphp
<h1>wasfa</h1>
<h1>reservation</h1>

{{$wasfa->wasfa->name}}<br>
{{$wasfa->chef->name}}<br>
<hr>
========wasfa content======
@foreach($wasfa_content as $content)
saddsa
{{$content->wasfa_contents->name}}
{{$pric+=$content->wasfa_contents->price}}
{{$content->wasfa_contents->image}}

@endforeach
<form method="POST" action="{{route('user.payment.store')}}">
    @csrf
    <input type="hidden" name="type" value="wasfas">
    <input type="hidden" name="type_id" value="{{$wasfa->id}}">
    <input type="hidden" name="price" value="{{$pric}}">
    <select name="type_payment">
        <option>جوال باي</option>
        <option>فيزا كارد</option>
        <option>الدفع عند الاستلام</option>

    </select>
    <button>دفع</button>
</form>
<hr>
@endsection