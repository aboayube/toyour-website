@extends('layouts.dashborad.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i>تعليقات المستخدمين </h1>
    </div>
</div>
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
                                <th class="border-bottom-0"> اسم المستخدم </th>
                                <th class="border-bottom-0">ايميل </th>
                                <th class="border-bottom-0">الرسالة </th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactus as $contact)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->message }}</td>
                                <td>
                                    <a class="modal-effect btn btn-sm btn-danger" data-id="{{ $contact->id }}" data-title="{{$contact->name}}" data-toggle="modal" id="showDeleteModelservice" href="showDeleteModelservice" title="حذف"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{$contactus->links()}}
                    </div>
                </div>
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
                <form action="{{route('admin.contactus.delete')}}" method="POST">
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
@endpush