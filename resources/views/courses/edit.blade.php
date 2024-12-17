@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>تعديل محتوى الكورس: {{ $course->name }}</h1>
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div id="lessons-container">
            @foreach(json_decode($course->content, true) as $index => $lesson)
            <div class="lesson">
                <h4>الدرس {{ $index + 1 }}</h4>
                <div class="form-group">
                    <label>اسم الدرس</label>
                    <input type="text" name="lessons[{{ $index }}][title]" value="{{ $lesson['title'] }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>نوع الفيديو</label>
                    <select name="lessons[{{ $index }}][video_type]" class="form-control">
                        <option value="youtube" {{ $lesson['video_type'] == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="uploaded" {{ $lesson['video_type'] == 'uploaded' ? 'selected' : '' }}>مرفوع</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>رابط الفيديو</label>
                    <input type="text" name="lessons[{{ $index }}][video_url]" value="{{ $lesson['video_url'] }}" class="form-control" required>
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
