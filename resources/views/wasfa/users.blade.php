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
            @foreach ($wasfas as $x)

            <tr>
                <td>{{$loop->iteration }}</td>

                <td>{{ $x->wasfa->name}}</td>

                <td>{{ $x->chef->name }}</td>
                <td>{{ $x->status }}</td>
                @if ($x->status=="approve" && $x->payment_status=="0")
                <td>
                    <form method="POST" action="{{route('user.payment.create.wasfa')}}">
                        @csrf <input type="hidden" value="{{$x->wasfa_id }}" name="id">
                        <input type="hidden" value="{{$x->chef->id}}" name="chif_id">

                        <button class="dropdown-item"><i class="bx bx-log-out"></i>
                            <i class="fa fa-sign-out fa-lg"></i>دفع</button>

                    </form>


                </td>
                @endif

                @if($x->status=='end')
                <td>تم انتهاء الطلب</td>

                @endif
                @if($x->status=='payment' && $x->payment_status==1) <td>جاري التنفيذ
                </td>

                @endif
                @if($x->status=='finish')


                <td>
                    <form method="POST" action="{{route('user.rating.rating')}}">
                        @csrf <input type="hidden" value="{{$x->id}}" name="id">
                        <input type="hidden" value="{{$x->chef_id}}" name="chef_id">
                        <input type="hidden" value="{{$x->wasfa_id }}" name="wasfa_id">

                        <button class="dropdown-item"><i class="bx bx-log-out"></i>
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
        {{$wasfas->links()}}
    </table>


</div>


@endsection