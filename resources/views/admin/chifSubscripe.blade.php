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
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">

                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                </div>
            </div>
            <div class="card-body">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-arabic" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>صورة</th>
                                    <th>عنوان</th>
                                    <th>الطباخ</th>
                                    <th>سعر</th>
                                    <th>الحاله</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $x)
                                <tr>
                                    <td>{{$loop->iteration }}</td>


                                    <td>{{ $x->user->name }}</td>
                                    <td>{{ $x->service->name }}</td>
                                    <td>{{ $x->service->price }}</td>
                                    <td>{{ $x->service->day }}</td>
                                    <td>{{ $x->status ? 'مفعل':'غير مفعل'}}</td>
                                    @if($x->user_id==auth()->id() || auth()->user()->role=='admin')

                                    <td>
                                        <a class="modal-effect btn btn-sm btn-info" data-id="{{ $x->id }}" data-toggle="modal" id="showEditModelPost" href="javascript:void(0)" title="تعديل"><i class="fa fa-edit"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $x->id }}" data-title="{{ $x->title }}" data-toggle="modal" href="#deletePostModel" title="حذف"><i class="fa fa-trash"></i></a>

                                    </td>
                                    @else
                                    <td>...</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            {{$services->links()}}
                        </table>
                    </div>
                </div>
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

@endsection
@push('scripts')
<script>
    $(document).ready(function() {


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