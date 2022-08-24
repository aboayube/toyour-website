@extends('layouts.app')
@section("content")

<section class="contact-section" style="
    margin-top: 96px;
    margin-right: 276px;">
    <div class="container">
        <div class="contact-box">
            <div class="title-section">
                <h2>حجز الطباخ {{$chef->name}}</h2>

            </div>
            <form action="{{route('user.reservation.store')}}" method="POST" class="php-email-form">
                @csrf
                <input type="hidden" name="chif_id" value="{{$chef->id}}">
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name"> الوجبة اسم</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">يوم</label>
                        <input type="text" name="date" class="form-control" id="date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">من ساعة </label>
                        <input type="text" name="start_from" class="form-control" id="start_from" required>
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">الي ساعة</label>
                        <input type="text" name="end_from" class="form-control" id="end_from" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">عنوان</label>
                        <input type="text" name="location" class="form-control" id="location" required>
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">عدد الضيوف</label>
                        <input type="text" name="number_user" class="form-control" id="number_user" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">ملاحظات</label>
                    <textarea class="form-control" name="notes" rows="10" required></textarea>
                </div><button type="submit" class="btn btn-primary mt-2">Send Message</button>
            </form>
        </div>

    </div>
</section>

@endsection