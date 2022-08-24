@extends("layouts.app")
@section('content')
<section class="menu-section style-two  text-center" style="margin-top:200px">
    <div class="menu-box">
        <div class="container">
            <div class="menu-title">
                <h1 class="mb-2">{{$wasfa->user->name}}</h1>
                <img src="{{$wasfa->image}}" width="100%" height="385px" alt="">

                <p>category:{{$wasfa->category->name}}</p>
                <p>time_make:{{$wasfa->time_make}}</p>
                <p>price:{{$wasfa->price}}</p>
                <p>discription:{{$wasfa->discription}}</p>
            </div>

            <div class="row">
                <form method="POST" action="{{route('user.wasfas.store')}}">
                    @csrf
                    <input type="hidden" name="chef_id" value="{{$wasfa->user->id}}">
                    <input type="hidden" name="id" value="{{$wasfa->id}}">
                    كمية المطلوبة <input type="number" name="countity">
                    @forelse ($wasfa->wasfa_content()->where('status',"1")->get() as $content)

                    <div class="col-md-6">
                        <div class="menu-holder">
                            <ul class="menu-list">
                                <li>
                                    <div class="img-box">
                                        <img src="{{$content->image}}" alt="">
                                    </div>
                                    <div class="menu-cont">
                                        <h4>
                                            اسم <span class="title-menu">{{$content->name}}</span>
                                            سعر <span class="price">${{$content->price}}</span>
                                        </h4>
                                        <input type="checkbox" value="{{$content->id}}" name="content[]">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @endforeach

                    ملاحظات <textarea name="note"></textarea>

                    <button>add</button>


            </div>
        </div>
    </div>



</section>
@endsection