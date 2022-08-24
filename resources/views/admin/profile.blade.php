@extends('layouts.dashborad.app')

@section('content')
@php
$user=auth()->user();

@endphp
<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i>تعديل الحساب </h1>
    </div>

</div>
<div class="row">

    <div class="col-md-6">
        <img src="{{asset('assets/users/'.auth()->user()->image)}}" width="80%" />
    </div>

    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">بيانات شخصية</h3>
            <div class="tile-body">


                <form style="
    overflow: hidden;" action="{{route('admin.profile.edit')}}" method="POST" class="text-center" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                    <div class="form-group">
                        <label class="control-label"> عنوان</label>
                        <input class="form-control" type="text" placeholder="Enter location" name="location" value="{{old('location',$user->location)}}">
                        @error('location')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label"> سعر</label>
                        <input class="form-control" type="number" placeholder="Enter location" name="price" value="{{old('price',$user->price)}}">
                        @error('mobile')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label class="control-label"> وصف</label>
                        <textarea class="form-control" name="discription"> {{old('discription',$user->discription)}}</textarea>
                        @error('discription')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label"> رقم الجوال</label>
                        <input class="form-control" type="text" placeholder="Enter location" name="mobile" value="{{old('mobile',$user->mobile)}}">
                        @error('mobile')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label class="control-label">كلمة السر</label>
                        <input class="form-control" type="password" placeholder="Enter full password" name="password">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label">تاكيد كلمة السر</label>
                        <input class="form-control" type="password" name="confirm_password" placeholder="Enter full confirm_password">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label">صورة شخصية </label>
                        <input class="form-control" type="file" name="image">
                        @error('image')
                        <span class="text-danger">{{$message}}</span>

                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
                </form>
            </div>
            <div class="tile-footer"> </div>
        </div>
    </div>
</div>
@endsection