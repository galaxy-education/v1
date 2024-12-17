@extends('layouts.dashboard')

@section('content')
<style>


h1, h3, h4 {
    color: #333;
}

.btn {
    border-radius: 30px;
    padding: 10px 25px;
    transition: background-color 0.3s;
}

.btn-primary:hover, .btn-success:hover, .btn-warning:hover, .btn-danger:hover {
    background-color: #0056b3 !important;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.2rem;
    color: #555;
}

.card-text {
    font-size: 1rem;
    color: #777;
}

</style>
<div class="container">
    <h1 class="mb-4">إضافة كورس جديد</h1>

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Step 1: أساسيات الكورس -->
        <div id="step1" class="step">
            <h3 class="font-weight-bold mb-4">أساسيات الكورس</h3>
            <div class="form-group">
                <label for="courseName">اسم الكورس</label>
                <input type="text" name="name" class="form-control shadow-sm" id="courseName" required>
            </div>
            <div class="form-group">
                <label for="coursePrice">السعر</label>
                <input type="number" name="price" class="form-control shadow-sm" id="coursePrice" required>
            </div>
            <div class="form-group">
                <label for="courseImage">الصورة</label>
                <input type="file" name="image" class="form-control shadow-sm" id="courseImage" required>
            </div>
            <button type="button" class="btn btn-primary mt-3 shadow-lg" onclick="goToStep(2)">التالي</button>
        </div>

        <!-- Step 2: إضافة الدروس -->
        <div id="step2" class="step" style="display: none;">
            <h3 class="font-weight-bold mb-4">إضافة الدروس</h3>
            <div id="lessons">
                <div class="lesson">
                    <h4>درس 1</h4>
                    <div class="form-group">
                        <label>اسم الدرس</label>
                        <input type="text" name="content[0][title]" class="form-control shadow-sm" required>
                    </div>
                    <div class="form-group">
                        <label>نوع الفيديو</label>
                        <select name="content[0][video_type]" class="form-control shadow-sm">
                            <option value="youtube">YouTube</option>
                            <option value="uploaded">مرفوع</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>رابط الفيديو أو رفع الملف</label>
                        <input type="text" name="content[0][video_url]" class="form-control shadow-sm" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addLesson()">إضافة درس جديد</button>
            <button type="submit" class="btn btn-success mt-3 shadow-lg">حفظ الكورس</button>
        </div>
    </form>
</div>

<script>
    let currentStep = 1;

    // الانتقال بين الخطوات
    function goToStep(step) {
        if (step === 2) {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        }
    }

    // إضافة درس جديد
    function addLesson() {
        const lessonsContainer = document.getElementById('lessons');
        const lessonIndex = lessonsContainer.getElementsByClassName('lesson').length;

        const lessonDiv = document.createElement('div');
        lessonDiv.classList.add('lesson', 'mb-3');
        lessonDiv.innerHTML = `
            <h4>درس ${lessonIndex + 1}</h4>
            <div class="form-group">
                <label>اسم الدرس</label>
                <input type="text" name="content[${lessonIndex}][title]" class="form-control shadow-sm" required>
            </div>
            <div class="form-group">
                <label>نوع الفيديو</label>
                <select name="content[${lessonIndex}][video_type]" class="form-control shadow-sm">
                    <option value="youtube">YouTube</option>
                    <option value="uploaded">مرفوع</option>
                </select>
            </div>
            <div class="form-group">
                <label>رابط الفيديو أو رفع الملف</label>
                <input type="text" name="content[${lessonIndex}][video_url]" class="form-control shadow-sm" required>
            </div>
        `;
        lessonsContainer.appendChild(lessonDiv);
    }
</script>
@endsection
