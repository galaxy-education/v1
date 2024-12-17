@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1>إضافة مرحلة دراسية جديدة للمدرسة: {{ $school->name }}</h1>

    <form action="{{ route('schools.education.store', $school->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">اسم المرحلة الدراسية</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">حفظ</button>
    </form>
</div>
@endsection
