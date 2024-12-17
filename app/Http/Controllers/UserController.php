<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
use App\Models\Invitation;

class UserController extends Controller
{

    public function updateProfile(Request $request)
{
    try {
        $user = Auth::user();

        if ($request->has('phone')) {
            $user->phone_number = $request->input('phone');
            $user->save();
        }

        if ($request->has('about') || $request->has('baba_phone') || $request->has('education_levels')) {
            $profile = $user->profile ?: new Profile();
            $profile->user_id = $user->id;
            $profile->about = $request->input('about');
            $profile->baba_phone = $request->input('baba_phone');
            $profile->education_levels = json_encode($request->input('education_levels'));
            $profile->save();
        }

        if ($request->has('invitation_code')) {
            $invitationCode = Invitation::where('invitation_code', $request->input('invitation_code'))->first();
            if ($invitationCode) {
                $invitationCode->used_by = array_merge($invitationCode->used_by ?: [], [$user->id]);
                $invitationCode->save();
            }
        }

        return response()->json(['message' => 'تم تحديث البيانات بنجاح']);
    } catch (\Exception $e) {
        // إرسال رسالة الخطأ إلى الواجهة الأمامية
        return response()->json([
            'message' => 'حدث خطأ غير متوقع.',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
