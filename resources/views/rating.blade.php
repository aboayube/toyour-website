@extends("layouts.app")
@section('content')
<div class="container" style="margin-top:200px !important">
    {{$rating->wasfa->name}}<br>
    {{$rating->chef->name}}<br>
    {{$rating->wasfa->price}}<br>

    <form method="POST" action="{{route('user.rating.store')}}">
        @csrf
        <input type="hidden" name="id" value="{{$rating->id}}">
        <input type="hidden" name="wasfa_id" value="{{$rating->wasfa->id}}">

        <input type="hidden" name="chef_id" value="{{$rating->wasfa->user_id}}">
        <input type="text" name="rating" value="">
        <textarea name="note"></textarea>
        <button>تقييم</button>
    </form>
</div>
@endsection