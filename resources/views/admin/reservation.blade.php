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

			</div>
			<div class="card-body">
				<div class="tile-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-arabic" id="sampleTable">
							<thead>
								<tr>
									<th>id</th>
									<th>اسم الاكلة</th>
									<th>الطباخ</th>
									<th>الحاله</th>
									<th>action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($reservations as $x)

								<tr>
									<td>{{$loop->iteration }}</td>

									<td>{{ $x->name}}</td>

									<td>{{ $x->user->name }}</td>
									<td>{{ $x->status}}</td>
									{{$x->payment_status}}
									@if($x->status=="aprove" && $x->payment_status==0)
									<td>بانتظار عملية الدفع</td>

									@endif

									@if ($x->payment_status=="1" && $x->status=='payment')
									<td>
										<form action="{{route('admin.reservation.status.update')}}" method="post">
											<input type="hidden" name="id" value="{{$x->id}}">
											<input type="hidden" name="status" value="finish" />
											@csrf
											<button type="submit" class="btn btn-primary">انتهي تنفيذ الطلبية</button>
										</form>
									</td>
									@endif

									@if($x->chif_id==auth()->id() && $x->status=='request')

									<td>
										<a class="modal-effect btn btn-sm btn-info" data-id="{{ $x->id }}" data-toggle="modal" id="showdataModelPost" href="javascript:void(0)" title="حالة"><i class="fa fa-eye"></i></a>

										<a class="modal-effect btn btn-sm btn-info" data-id="{{ $x->id }}" data-toggle="modal" id="showstatsModelPost" href="javascript:void(0)" title="حالة"><i class="fa fa-edit"></i></a>


									</td>
									@endif


									@if($x->status=='cancle' ||$x->status=='finish')
									<td>انتهت الطلبية</td>
									@endif






								</tr>
								@endforeach
							</tbody>
							{{$reservations->links()}}
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="postshowModel" style="overflow:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">تعديل مقاله</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">

				<div id="id_show"></div>
				<div id="name_show"></div>
				<div id="date_show"></div>
				<div id="start_from_show"></div>
				<div id="end_from_show"></div>
				<div id="location_show"></div>
				<div id="number_user_show"></div>
				<div id="notes_show"></div>
			</div>
		</div>
	</div>
</div>


<!-- status -->
<div class="modal" id="showstatusmodel" style="overflow:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">تعديل مقاله</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.reservation.status.update')}}" method="post" style="    direction: rtl;">
					@csrf
					<input type="hidden" name="id" id="id_status">
					<div class="form-group">
						<label for="exampleInputEmail1"> اكلة اسم</label>
						<select name="status" id="status" class="form-control">
							<option value="cancle">الغاء الطلب </option>
							<option value="aprove"> موافقه علية</option>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

@endsection
@push('scripts')
<script>
	$(document).ready(function() {


		$('body').on('click', '#showdataModelPost', function() {
			var cat_id = $(this).data('id');
			$.get('/admin/reservation/edit/' + cat_id, function(data) {
				console.log(data);
				$('#postshowModel').modal('show');
				$('#id_show').html(data.id);
				$('#name_show').html(data.name);
				$('#date_show').html(data.date);
				$('#start_from_show').html(data.start_from);
				$('#end_from_show').html(data.end_from);
				$('#location_show').html(data.location);
				$('#number_user_show').html(data.number_user);
				$('#notes_show').html(data.notes);



			});
		});
		$('body').on('click', '#showstatsModelPost', function() {
			var cat_id = $(this).data('id');
			$.get('/admin/reservation/show/' + cat_id, function(data) {
				console.log(data);
				$('#showstatusmodel').modal('show');
				$('#id_status').val(data.id);
				$(`#status option[value='${data.status}']`).prop('selected', true);



			});
		});
		$('body').on('click', '#showEditModelPost', function() {
			var cat_id = $(this).data('id');
			$.get('/admin/reservation/edit/' + cat_id, function(data) {
				console.log(data);
				$('#postEditModel').modal('show');
				$('#id').val(data.id);
				$('#name').val(data.name);
				$('#date').val(data.date);
				$('#start_from').val(data.start_from);
				$('#end_from').val(data.end_from);
				$('#location').val(data.location);
				$('#number_user').val(data.number_user);
				$('#notes').val(data.notes);
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