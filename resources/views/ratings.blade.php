@extends('layouts.app')

@section("content")
@foreach ($ratings as $rating)
{{$rating->wasfa->name}}
{{$rating->wasfa->user->name}}
{{$rating->wasfa->price * $rating->countity}}
<a href="{{route('admin.rating.rating',$rating->id)}}">تقييم الشيف</a>
<hr>
@endforeach

@endsection