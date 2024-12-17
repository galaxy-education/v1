<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
{
    $courses = \App\Models\Course::all();
    return view('courses.index', compact('courses'));
}
public function create()
{
    return view('courses.create');
}

public function store(Request $request)
{
    // التحقق من صحة البيانات التي تم إرسالها من الفورم
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'required|image',
    ]);

    // تخزين الصورة في المسار المخصص لها
    $path = $request->file('image')->store('courses', 'public');

    // حفظ الكورس في قاعدة البيانات
    $course = \App\Models\Course::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'image' => $path,
        'content' => json_encode($request->content), // حفظ الدروس والفيديوهات في عمود content بتنسيق JSON
    ]);

    return redirect()->route('courses.index')->with('success', 'تم إضافة الكورس بنجاح!');
}
public function edit($id)
{
    $course = \App\Models\Course::findOrFail($id);
    return view('courses.edit', compact('course'));
}

public function update(Request $request, $id)
{
    $course = \App\Models\Course::findOrFail($id);

    $validated = $request->validate([
        'lessons' => 'required|array',
        'lessons.*.title' => 'required|string|max:255',
        'lessons.*.video_type' => 'required|in:youtube,uploaded',
        'lessons.*.video_url' => 'required|string',
    ]);

    $course->content = $validated['lessons'];
    $course->save();

    return redirect()->route('courses.index')->with('success', 'تم تحديث الكورس بنجاح!');
}
public function destroy($id)
{
    $course = \App\Models\Course::findOrFail($id);
    $course->delete();

    return redirect()->route('courses.index')->with('success', 'تم حذف الكورس بنجاح!');
}

}
