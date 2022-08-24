@extends('layouts.dashborad.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<style>
    .note-editable {

        height: 599.425px;
        background: #eee;
    }
</style>
<!-- row -->
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i>طلبات المستخدمين</h1>
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
            <div class="card-header pb-0">

            </div>
            <div class="card-body">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-arabic" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>صورة</th>
                                    <th>اسم الطبخة</th>
                                    <th>الطباخ</th>
                                    <th>سعر</th>
                                    <th>الكمية</th>
                                    <th>المستخدم</th>
                                    <th>الحاله</th>
                                    <th>الملاحظة</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wasfas_request as $wasfa)
                                <tr>
                                    <td><img src="{{asset('assets/wasfas/'.$wasfa->wasfa->image)}}" width="100" height="100"></td>
                                    <td>{{ $wasfa->wasfa->name}}</td>
                                    <td>{{ $wasfa->wasfa->user->name}}</td>
                                    <td>{{ $wasfa->wasfa->price }}</td>
                                    <td>{{ $wasfa->countity }}</td>
                                    <td>{{ $wasfa->user->name }}</td>
                                    <td>{{ $wasfa->note }}</td>
                                    <td>{{ $wasfa->status ? 'مفعل':'غير مفعل'}}</td>
                                    @if($wasfa->user_id==auth()->id() || auth()->user()->role=='admin')

                                    <td>
                                        <a class="modal-effect btn btn-sm btn-info" data-id="{{ $wasfa->id }}" data-toggle="modal" id="showEditModelPost" href="javascript:void(0)" title="تعديل"><i class="fa fa-edit"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $wasfa->id }}" data-title="{{ $wasfa->wasfa->name }}" data-toggle="modal" href="#deletePostModel" title="حذف"><i class="fa fa-trash"></i></a>

                                    </td>
                                    @else
                                    <td>...</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            {{$wasfas_request->links()}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit -->
<div class="modal" id="postEditModel" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل مقاله</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.card.update')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="exampleInputEmail1">حاله</label>
                        <select name="status" id="status">
                            <option value="0">غير مفعل</option>
                            <option value="1">مفعل</option>

                        </select>
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

<!-- delete -->
<div class="modal" id="deletePostModel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{route('admin.card.delete')}}" method="POST">

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

@endsection
@push('scripts')
<script>
    $(document).ready(function() {


        $('body').on('click', '#showEditModelPost', function() {
            var cat_id = $(this).data('id');
            $.get('/admin/card/edit/' + cat_id, function(data) {

                $('#postEditModel').modal('show');
                $('#edit_id').val(data.id);
                $(`#status option[value='${data.status}']`).prop('selected', true);



            });

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