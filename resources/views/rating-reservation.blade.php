@extends("layouts.app")
@section('content')
<form method="POST" action="{{route('user.ratingReservation.update')}}" style="margin-top:200px !important">
    @csrf
    <input type="hidden" name="id" value="{{$rating->id}}">

    <input type="hidden" name="chef_id" value="{{$rating->chif_id}}">
    تقييم <input type="text" name="rating" value="">
    ملاحظات <textarea name="note"></textarea>
    <button>تقييم</button>
</form>
@endsection