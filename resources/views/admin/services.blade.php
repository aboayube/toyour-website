@extends('layouts.dashborad.app')

@section('content')

<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i>خدمات الموقع</h1>
        <p>Table to display analytical data effectively</p>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
    </ul>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">

                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة خدمة</a>

                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-arabic" id="sampleTable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم الخدمة</th>
                                <th class="border-bottom-0">سعر</th>
                                <th class="border-bottom-0">حالة</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $x)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{ $x->name }}</td>
                                <td>{{ $x->price }}</td>
                                <td>{{ $x->status==1?"فعال":"غير فعال" }}</td>
                                <td>
                                    <a class="modal-effect btn btn-sm btn-info" data-id="{{ $x->id }}" data-toggle="modal" id="showEditModelCategory" href="javascript:void(0)" title="تعديل"><i class="fa fa-edit"></i></a>
                                    <a class="modal-effect btn btn-sm btn-danger" data-id="{{ $x->id }}" data-title="{{$x->name}}" data-toggle="modal" id="showDeleteModelservice" href="showDeleteModelservice" title="حذف"><i class="fa fa-trash"></i></a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{$services->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة خدمة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.services.store')}}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم الخدمة</label>
                            <input type="text" class="form-control" id="" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">عدد ايام الخدمة </label>
                            <input type="number" class="form-control" id="" name="day">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">مزايا الخدمة</label>
                            <textarea name="discription" class="form-control"></textarea>
                        </div>
                        <select name="status" id="status_user">
                            <option value="0">غير فعال</option>
                            <option value="1"> فعال</option>
                        </select>
                        <div class="form-group">
                            <label for="exampleInputEmail1">سعر </label>
                            <input type="number" class="form-control" id="" name="price">
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
    <div class="modal fade" id="categoryEditModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل اشتراك</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('admin.services.update')}}" method="POST">

                        @csrf
                        <input type="hidden" name="id" id="cat_id">

                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم الخدمة</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">عدد ايام الخدمة </label>
                            <input type="number" class="form-control" id="day" name="day">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">مزايا الخدمة</label>
                            <textarea name="discription" class="form-control" id="benefits"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">سعر </label>
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                        <select name="status" id="status_user">
                            <option value="0">غير فعال</option>
                            <option value="1"> فعال</option>
                        </select>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- delete -->
    <div class="modal" id="deleteCoateoryModel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> حذف الاشتراك</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('admin.services.delete')}}" method="POST">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="cat_id_delete" value="">
                        <input class="form-control" name="name" id="delete_title" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@push('scripts')
<!-- Internal Data tables -->

<script>
    // show
    $('body').on('click', '#showEditModelCategory', function() {
        var cat_id = $(this).data('id');
        $.get('/admin/services/edit/' + cat_id, function(data) {
            $('#categoryEditModel').modal('show');
            $('#cat_id').val(data.id);
            $('#name').val(data.name);
            $('#consulted').val(data.dscription);
            $('#type').val(data.type);
            $('#day').val(data.day);
            $('#benefits').val(data.discription);
            $('#price').val(data.price);
        })
    });
    //delete
    $('body').on('click', '#showDeleteModelservice', function() {
        var cat_id = $(this).data('id');
        var title = $(this).data('title');
        console.log(cat_id);
        $('#deleteCoateoryModel').modal('show');
        $('#cat_id_delete').val(cat_id);
        $('#delete_title').val(title);

    });
</script>
@include('sweetalert::alert')
@endpush