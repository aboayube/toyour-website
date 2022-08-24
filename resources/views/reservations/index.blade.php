@extends('layouts.app')
@section('content')
<div class="container mt-5 " style="margin-top:200px !important">
    <table class="table table-hover table-bordered table-arabic" id="sampleTable">
        <thead>
            <tr>
                <th>id</th>
                <th>اسم الاكلة</th>
                <th>الطباخ</th>
                <th>الحاله</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $x)

            <tr>
                <td>{{$loop->iteration }}</td>

                <td>{{ $x->name}}</td>

                <td>{{ $x->user->name }}</td>
                <td>{{ $x->status ? 'مفعل':'غير مفعل'}}</td>
                @if ($x->status=="aprove")
                <td>
                    <form method="POST" action="{{route('user.payment.create.reservation')}}">
                        <input type="hidden" value="{{$x->id}}" name="id">
                        <input type="hidden" value="{{$x->chif_id}}" name="chif_id">
                        @csrf
                        <button class="dropdown-item"><i class="bx bx-log-out"></i>
                            <i class="fa fa-sign-out fa-lg"></i>دفع</button>

                    </form>


                </td>
                @endif

                @if($x->status=='end')
                <td>تم انتهاء الطلب</td>

                @endif
                @if($x->status=='payment')
                <td>جاري التنفيذ
                </td>

                @endif
                @if($x->status=='finish')


                <td>
                    <form method="POST" action="{{route('user.ratingReservation.create')}}">
                        <input type="hidden" value="{{$x->id}}" name="id">
                        <input type="hidden" value="{{$x->chif_id}}" name="chif_id">
                        @csrf
                        <button class="dropdown-item" href="{{ route('user.ratingReservation.create') }}"><i class="bx bx-log-out"></i>
                            <i class="fa fa-sign-out fa-lg"></i>تقييم الطباخ</button>

                    </form>
                </td>
                @endif

                @if($x->status=="cancle")

                <td>طلب ملغي </td>

                @endif

                @if($x->status=='request') <td>
                    <a class="modal-effect btn btn-sm btn-info" href="{{route('user.reservation.edit',$x->id)}}" title="حالة">تعديل</a>


                    <form method="POST" action="{{route('user.reservation.delete')}}">
                        <input type="hidden" value="{{$x->id}}" name="id">
                        <input type="hidden" value="{{$x->chif_id}}" name="chif_id">
                        @csrf
                        <button class="dropdown-item" href="{{ route('user.reservation.delete') }}"><i class="bx bx-log-out"></i>
                            <i class="fa fa-sign-out fa-lg"></i>حذف</button>

                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
        {{$reservations->links()}}
    </table>


</div>


@endsection