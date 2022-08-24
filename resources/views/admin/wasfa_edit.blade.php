@extends('layouts.dashborad.app')
@section('content')
<form action="{{route('admin.wasfas.update')}}" method="post" enctype="multipart/form-data" style="    direction: rtl;">
    @csrf

    <input type="hidden" class="form-control" name="id" value="{{$wasfa->id}}">
    <div class="form-group">
        <label for="exampleInputEmail1">اسم</label>
        <input type="text" class="form-control" id="" name="name" value="{{old('name',$wasfa->name)}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1"> وصف
        </label>
        <textarea class="form-control " id="" name="discription" value="">{{old('discription',$wasfa->discription)}}</textarea>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">القسم</label>
        <select name="category_id">
            @foreach ($cats as $cat)
            <option value="{{$cat->id}}" {{$cat->id==$wasfa->category_id?"selected":"null"}}>{{$cat->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1"> عدد المستخدمين</label>
        <input type="number" class="form-control" id="" value="{{$wasfa->number_user}}" name="number_user" value="{{old('number_user')}}">
        @error('number_user')
        <span class="text-danger help-block">{{$message}} </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">سعر</label>
        <input type="number" class="form-control" id="" name="price" value="{{old('price',$wasfa->price)}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">وقت العمل</label>
        <input type="number" class="form-control" id="" name="time_make" value="{{old('time_make',$wasfa->time_make)}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">حاله</label>
        <select name="status">
            <option value="0" {{$wasfa->status==0?"selected":"null"}}>غير مفعل</option>
            <option value="1" {{$wasfa->status==1?"selected":"null"}}>مفعل</option>

        </select>
    </div>

    <table class="table" id="invoice_details">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم</th>
                <th>سعر</th>
                <th>صورة</th>
                <th>حالة</th>
            </tr>
        </thead>
        <tbody>
            <button type="button" class="btn btn-primary btn_add">+</button>
            @foreach($wasfa->wasfa_content as $key =>$wasfa_content)
            <tr class="cloning_row" id="0">
                <td>#</td>
                <td>
                    <img src="{{$wasfa_content->image}}" width="60px" height="60px">
                </td>

                <td>
                    <input type="text" name="element[{{$key}}]" id="element" class="name form-control" value="{{$wasfa_content->name}}">
                    @error('name')
                    <span class="text-danger help-block">{{$message}} </span>
                    @enderror
                </td>
                <td>
                    <input type="number" name="element_value[{{$key}}]" id="element_value" class="element_value form-control" value="{{$wasfa_content->price}}">
                    @error('element_value')
                    <span class="text-danger help-block">{{$message}} </span>
                    @enderror
                </td>
                <td>
                    <input type="hidden" name="element_img_empty[{{$key}}]" value="{{$wasfa->image}}">
                    <input type="file" name="element_img[{{$key}}]">
                    @error('element_img')
                    <span class="text-danger help-block">{{$message}} </span>
                    @enderror
                </td>
                <td>
                    <select name="element_status[{{$key}}]">
                        <option value="0" {{$wasfa_content->status==0?'selected':'null'}}>0</option>
                        <option value="1" {{$wasfa_content->status==1?'selected':'null'}}>1</option>
                    </select>
                    @error('element_status')
                    <span class="text-danger help-block">{{$message}} </span>
                    @enderror
                </td>
                <td colspan="6">
                    <button type="button" class="delegated-btn btn btn-primary">+</button>
                </td>
                <td><img src="{{asset('assets/wasfas/parent/'.$wasfa_content->image)}}" alt="" width="100px">
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div class="form-group">
        <label for="exampleInputEmail1">صورة مقال</label>
        <input type="file" name="image">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">تاكيد</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
    </div>


</form>

@endsection

@push('scripts')

<script>
    // حذف
    $(document).on('click', '.delegated-btn', function(ee) {
        ee.preventDefault();
        $(this).parent().parent().remove()
    });
    $(document).on('click', '.btn_add', function() {
        let trCount = $("#invoice_details").find('tr.cloning_row:last').length;
        let numberIncr = trCount > 0 ? parseInt($("#invoice_details").find('tr.cloning_row:last').attr('id')) + 1 : 0;
        $("#invoice_details").find('tbody').append($('' +
            '<tr class="cloning_row" id="' + numberIncr + '">' +
            '<td><button type="button" class="btn btn-danger btn-sm delegated-btn"><i class="fa fa-minus"></i></button></td>' +
            '<td><input type="text" name="element[' + numberIncr + ']" class="element form-control"></td>' +
            '<td><input type="number" name="element_value[' + numberIncr + ']"  class="element_value form-control"></td>' +
            '<td><input type="file" name="element_img[' + numberIncr + ']"  class="element_img form-control"></td>' +
            '<td><select name="element_status[' + numberIncr + ']"  class="element_img form-control"><option value="0">0</option><option value="1">1</option></select></td>' +

            '</tr>'))
    });
</script>
@endpush