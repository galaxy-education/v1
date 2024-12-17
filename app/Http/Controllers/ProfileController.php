<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    // دالة لحفظ البروفايل في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|string',
            'baba_phone' => 'nullable|string',
            'education_levels' => 'nullable|json',
            'moduels' => 'nullable|json',
        ]);

        // رفع الصورة وتخزين مسارها
        $photoPath = $request->file('photo')->store('photos', 'public');

        // إنشاء البروفايل وحفظه في قاعدة البيانات
        Profile::create([
            'user_id' => Auth::id(),
            'photo' => $photoPath,
            'about' => $request->about,
            'baba_phone' => $request->baba_phone,
            'education_levels' => $request->education_levels,
            'moduels' => $request->moduels,
        ]);

        return redirect()->back();
    }
}
