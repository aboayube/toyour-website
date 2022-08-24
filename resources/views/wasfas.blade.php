@extends('layouts.app')
@section('content')
<section id="about" class="about " style="
    margin-top: 116px !important;
">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>اخر الوصفات</h2>
        </div>

        <div class="row content">
            @foreach($wasfas as $wasfa)
            <div class="col-sm-3 col-xs-12 mt-5">
                <div class="text-center service">
                    <img src="{{asset('assets/wasfas/'.$wasfa->image)}}" class="img-fluid" alt="" style="
               
    width: 269px;
    height: 250px;
    border-radius: 50%;">
                    <h1 class="mt-3">{{$wasfa->name}}</h1>
                    <p><span>سعر:</span>{{$wasfa->price}}</p>
                    <p>{{substr($wasfa->discription,0,100)}}..</p>
                    <button class="btn-started">اطلب الأن</button>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection