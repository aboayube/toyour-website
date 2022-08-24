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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-arabic" id="sampleTable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم الخدمة</th>
                                <th class="border-bottom-0">سعر</th>
                                <th class="border-bottom-0">الطباخ</th>
                                <th class="border-bottom-0">تاريخ انتهاء</th>\
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $x)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{ $x->service->name }}</td>
                                <td>{{ $x->service->price }}</td>
                                <td>{{ $x->user->name }}</td>
                                <td>{{ $x->end_at->diffForHumans(); }}</td>

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