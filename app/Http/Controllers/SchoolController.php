<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Education;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    // عرض جميع المدارس مع المراحل الدراسية الخاصة بها
    public function index()
    {
        $schools = School::with('education_level')->get();
        return view('schools.index', compact('schools'));
    }

    // عرض نموذج إضافة مدرسة جديدة
    public function create()
    {
        return view('schools.create');
    }

    // إضافة مدرسة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $school = School::create($request->all());

        return redirect()->route('schools.index')->with('success', 'تم إضافة المدرسة بنجاح');
    }

    // عرض نموذج إضافة مرحلة دراسية جديدة للمدرسة
    public function createEducation($schoolId)
    {
        $school = School::findOrFail($schoolId);
        return view('educations.create', compact('school'));
    }

    // إضافة مرحلة دراسية جديدة للمدرسة
    public function storeEducation(Request $request, $schoolId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school = School::findOrFail($schoolId);
        $school->education_level()->create($request->all());

        return redirect()->route('schools.index')->with('success', 'تم إضافة المرحلة الدراسية بنجاح');
    }
}
