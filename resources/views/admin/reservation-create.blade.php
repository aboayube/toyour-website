<form action="{{route('admin.reservation.store')}}" method="post" style="    direction: rtl;">
    @csrf
    <input type="hidden" value="{{$id}}" name="chif_id">
    <div class="form-group">
        <label for="exampleInputEmail1"> اكلة اسم</label>
        <select name="name">
            @foreach($wasfas as $wasfa)
            <option value="{{$wasfa->name}}">{{$wasfa->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1"> يوم
        </label>
        <input type="text" class="form-control" id="" name="date" value="{{old('date')}}">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">يبدا من
        </label>
        <input type="text" class="form-control" id="" name="start_from" value="{{old('start_from')}}">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1"> ينتهي من
        </label>
        <input type="text" class="form-control" id="" name="end_from" value="{{old('end_from')}}">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">موقع</label>
        <input type="text" class="form-control" id="" name="location" value="{{old('location')}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">عدد ضيوف</label>
        <input type="number" class="form-control" id="" name="number_user" value="{{old('number_user')}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">ملاحظات</label>
        <textarea id="exampleInputEmail1" class="form-control" name="notes" rows="3">{{old('notes')}}</textarea>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">تاكيد</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
    </div>
</form>