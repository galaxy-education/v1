@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1>إضافة مدرسة جديدة</h1>

    <form action="{{ route('schools.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">اسم المدرسة</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">وصف المدرسة</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">حفظ</button>
    </form>
</div>
@endsection
