@extends('layouts.dashborad.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<style>
    .note-editable {

        height: 599.425px;
        background: #eee;
    }

    .modal-content-demo {
        width: 1000px
    }
</style>
<!-- row -->
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i>مقالات</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
    </ul>
</div>
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">

            <div class="card-body">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-arabic" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>صورة</th>
                                    <th>عنوان</th>
                                    <th>اسم الطبخة</th>
                                    <th>سعر</th>
                                    <th>الحاله</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wasfacontents as $x)
                                <tr>
                                    <td>{{$loop->iteration }}</td>
                                    <td><img src="{{$x->image}}" width="100" height="100"></td>
                                    <td>{{ $x->name}}</td>

                                    <td>{{ $x->wasfa->name }}</td>
                                    <td>{{ $x->price }}</td>
                                    <td>{{ $x->status ? 'مفعل':'غير مفعل'}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                            {{$wasfacontents->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- اضافة مقاله -->
<div class="modal" id="modaldemo8" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة وصفة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.wasfas.store')}}" method="post" enctype="multipart/form-data" style="    direction: rtl;">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم</label>
                        <input type="text" class="form-control" id="" name="name" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> وصف
                        </label>
                        <textarea class="form-control " id="" name="discription" value="{{old('discription')}}"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">سعر</label>
                        <input type="number" class="form-control" id="" name="price" value="{{old('price')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وقت العمل</label>
                        <input type="number" class="form-control" id="" name="time_make" value="{{old('time_make')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">حاله</label>
                        <select name="status">
                            <option value="0">غير مفعل</option>
                            <option value="1">مفعل</option>

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
                            <tr class="cloning_row" id="0">
                                <td>#</td>
                                <td>
                                    <input type="text" name="element[0]" id="element" class="name form-control">
                                    @error('name')
                                    <span class="text-danger help-block">{{$message}} </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="element_value[0]" id="element_value" class="element_value form-control">
                                    @error('element_value')
                                    <span class="text-danger help-block">{{$message}} </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="file" name="element_img[0]">
                                    @error('element_img')
                                    <span class="text-danger help-block">{{$message}} </span>
                                    @enderror
                                </td>
                                <td>
                                    <select name="element_status[0]">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                    @error('element_status')
                                    <span class="text-danger help-block">{{$message}} </span>
                                    @enderror
                                </td>
                                <td colspan="6">
                                    <button type="button" class="btn_add btn btn-primary">+</button>
                                </td>
                            </tr>
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
            </div>
        </div>
    </div>
    <!-- End Basic modal -->
</div>
<!-- edit -->
<div class="modal" id="postEditModel" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل مقاله</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.wasfas.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان</label>
                        <input type="text" class="form-control" id="title" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">محتوي مقاله</label>
                        <textarea name="discription" class="form-control " id="discription"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">سعر</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">وقت العمل</label>
                        <input type="number" class="form-control" id="time_make" name="time_make" value="{{old('time_make')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">حاله</label>
                        <select name="status" id="status">
                            <option value="0">غير مفعل</option>
                            <option value="1">مفعل</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">صورة مقال</label>
                        <input type="file" name="image">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- shoElementModel -->
<div class="modal" id="showElementModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <table class="table key-buttons text-md-nowrap" id="element_details">
                    <thead>
                        <tr>
                            <td>رقم</td>
                            <td>اسم</td>
                            <td>كميه</td>
                        </tr>
                    </thead>
                    <tbody>



                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->


</div>
<!-- delete -->
<div class="modal" id="deletePostModel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{route('admin.wasfas.delete')}}" method="POST">

                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="title" id="title" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
        </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
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
        }); // حذف
        $(document).on('click', '.delegated-btn', function(ee) {
            ee.preventDefault();
            $(this).parent().parent().remove()
        });
        $('body').on('click', '#showEditModelPost', function() {
            var cat_id = $(this).data('id');
            $.get('/admin/wasfa/edit/' + cat_id, function(data) {

                $('#postEditModel').modal('show');
                $('#id').val(data.id);
                $('#title').val(data.name);
                $('#discription').val(data.discription);
                $('#price').val(data.price);
                $('#image').val(data.image);
                $('#time_make').val(data.time_make);
                $(`#category_id option[value='${data.category_id}']`).prop('selected', true);
                $(`#status option[value='${data.status}']`).prop('selected', true);



            });

        })

        $(() => {

            //لما يروح الضغط عن اضهار العناصر
            $('#showElementModel').on('hidden.bs.modal', function(event) {

                $('#element_details').find('tbody tr').remove();
            })

        })
        $('#deletePostModel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #title').val(title);
        })
    })
</script>
@endpush