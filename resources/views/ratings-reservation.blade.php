@extends('layouts.app')

@section("content")
<div style="margin-top:500px !important">

    @foreach ($ratings as $rating)
    {{$rating->name}}<br>
    {{$rating->user->name}}<br>
    {{$rating->chif->name}}<br>
    <a href="{{route('admin.ratingreservation.rating',$rating->id)}}">تقييم الشيف</a>
    <hr>
    @endforeach
</div>
@endsection