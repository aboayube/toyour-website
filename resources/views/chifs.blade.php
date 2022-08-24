@extends('layouts.app')
@section('content') <section id="team" class="team section-bg" style="
    margin-top: 116px !important;
">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>الشيفات</h2>
        </div>

        <div class="row">
            @foreach($chefs as $chef)
            <div class="col-lg-6 mt-2">
                <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pic"><img src="{{asset('users/'.$chef->image)}}" class="img-fluid" width="200px" height="200px" alt=""></div>
                    <div class="member-info mt-5">
                        <h4>{{$chef->name}}</h4>
                        <span class="text-black">خبيرة في الطبخ </span>
                        <p>{{substr($chef->discription,0,50)}}</p>
                        <div class="social">
                            <a href="{{route('user.reservation.create',$chef->id)}}" class="btn-started2 pull-right " style="
                  margin-right: 250px;">حجز</a>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach


        </div>

    </div>
</section><!-- End Team Section -->


@endsection