@extends('layouts.app')
@section('content')

<section class="contact-section" style="
    margin-top: 96px;
    margin-right: 276px;">
    <div class="container">
        <div class="contact-box">
            <div class="title-section">
                <h2> انضم الينا</h2>

            </div>
            <form action="{{ route('register') }}" method="POST" class="php-email-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name"> نوع الحساب</label>
                        <select name="type" class="form-control">

                            <option value="chef">طباخ</option>
                            <option value="user">مستخدم</option>

                        </select>
                        @error('type')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name"> اسم</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" required>

                        @error('name')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="email">ايميل</label>
                        <input type="email" name="email" class="form-control" value="{{old('date')}}" id="date" required>

                        @error('email')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">رقم الجوال</label>
                        <input type="number" name="mobile" class="form-control" value="{{old('location')}}" id="location" required>

                        @error('mobile')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name">كلمة السر </label>
                        <input type="password" name="password" class="form-control" value="{{old('start_from')}}" id="start_from" required>

                        @error('password')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-5">
                        <label for="name"> تاكيد كلمة السر</label>
                        <input type="password" name="password_confirmation" class="form-control" value="{{old('end_from')}}" id="end_from" required>

                        @error('password_confirmation')
                        <span class="text-alert">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mt-5">
                        <label for="name"> الجنس</label>
                        <select name="gender" class="form-control">

                            <option value="1">ذكر</option>
                            <option value="0">انثي</option>

                            @error('gender')
                            <span class="text-alert">{{$message}}</span>
                            @enderror
                        </select>
                    </div>
                </div><button type="submit" class="btn btn-warning mt-2" style="color:white">سجل معنا</button>
            </form>
        </div>

    </div>
</section>