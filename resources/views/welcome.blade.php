@extends('layouts.app')
@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                <h1>اطلب طعامًا منزليًا عبر الإنترنت</h1>
                <h2>نعدك بأنك ستستمتع بكل لحظة حلوة ابحث عن ما تفضله الآن
                    وتناول ما تحب ووفِّر وقتك لشيء رائع!</h2>
                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a class="btn-header text-center pt-2" href="{{route('chif.index')}}">اطلب الآن </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('front_style/image/header.png')}}" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">
    <!-- End Cliens Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>اخر الوصفات</h2>
            </div>

            <div class="row content">

                @if(!empty($wasfas))
                @foreach ($wasfas as $wasfa)
                <div class="col-sm-3 col-xs-12">
                    <div class="text-center service">
                        <img src="{{asset('assets/wasfas/'.$wasfa->image)}}" class="img-fluid" style="
    width: 269px;
    height: 250px;
    border-radius: 50%;">
                        <h1 class="mt-3">{{$wasfa->name}}</h1>
                        <p><span>سعر:</span>{{$wasfa->price}}</p>
                        <p>{{substr($wasfa->discription,0,20)}}..</p>
                        <a class=" btn-started2  " style="display: inline-block; 
    padding-top: 5px;" href="{{route('user.wasfas.show',$wasfa->id)}}">اطلب الأن</a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Why Us Section ======= -->


    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>الشيفات</h2>
            </div>

            <div class="row">
                @foreach($chefs as $chef)
                <div class="col-lg-6 mt-3">
                    <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pic"><img src="{{asset('assets/users/'.$chef->image)}}" width="200px" height="200px" alt=""></div>
                        <div class="member-info mt-5">
                            <h4>{{$chef->name}}</h4>
                            <span class="text-black">خبيرة في الطبخ </span>
                            <p>{{substr($chef->discription,0,40)}}...</p>
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


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>تواصل معنا</h2>
            </div>

            <div class="row">

                <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                        <div class="address mt-5">
                            <i class="bi bi-geo-alt"></i>
                            <h4>عنوان:</h4>
                            <p>{{$setting->address }}</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>ايميل:</h4>
                            <p>{{$setting->email}}</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>تواصل معنا:</h4>
                            <p>+{{$setting->whatsapp}}</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="{{route('contactus.store')}}" method="POST" class="php-email-form">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">اسم</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">ايميل</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">رسالة</label>
                            <textarea class="form-control" name="message" rows="10" required></textarea>
                        </div><button type="submit">Send Message</button>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->


@endsection