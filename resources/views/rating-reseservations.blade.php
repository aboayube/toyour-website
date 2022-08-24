@extends("layouts.app")
@section('content')

<form method="POST" action="{{route('admin.rating.store')}}">
    @csrf
    <input type="hidden" name="id" value="{{$rating->id}}">
    <input type="hidden" name="wasfa_id" value="{{$rating->wasfa->id}}">

    <input type="hidden" name="chef_id" value="{{$rating->wasfa->user_id}}">
    <input type="text" name="rating" value="">
    <textarea name="note"></textarea>
    <button>تقييم</button>
</form>
@endsection