@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">إدارة الكورسات</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-success mb-4 shadow-lg">إضافة كورس جديد</a>

    <div class="row">
        @foreach($courses as $course)
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 rounded-lg">
                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->name }}">
                <div class="card-body">
                    <h5 class="card-title text-center font-weight-bold">{{ $course->name }}</h5>
                    <p class="card-text text-center text-muted">السعر: ${{ $course->price }}</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning mx-2">تعديل</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-2">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
