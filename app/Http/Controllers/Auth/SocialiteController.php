<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invitation; // استيراد نموذج Invitation
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'المزود غير مدعوم');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $userSocial = Socialite::driver($provider)->stateless()->user();

            // التحقق من وجود المستخدم أو إنشائه
            $user = User::updateOrCreate(
                ['email' => $userSocial->getEmail()],
                [
                    'name' => $userSocial->getName(),
                    'provider_id' => $userSocial->getId(),
                    'provider_name' => $provider,
                    'password' => bcrypt(Str::random(16)), // كلمة مرور عشوائية آمنة
                ]
            );

            // إنشاء كود الدعوة إذا كان التسجيل جديدًا
            if ($user->wasRecentlyCreated) {
                Invitation::create([
                    'user_id' => $user->id,
                    'invitation_code' => $this->generateUniqueInvitationCode(),
                ]);
            }

            Auth::login($user);

            return redirect()->route('profile.setup')->with('success', 'تم تسجيل الدخول بنجاح');

        } catch (Exception $e) {
            $errorMessage = 'حدث خطأ أثناء تسجيل الدخول. الرجاء المحاولة مرة أخرى.';

            // تخزين الرسالة المخصصة والخطأ التقني
            return redirect()->route('login')
                ->with('error', $errorMessage)
                ->with('error_details', $e->getMessage());
        }
    }

    // دالة لتوليد كود دعوة فريد
    private function generateUniqueInvitationCode()
    {
        $code = Str::random(10);

        // التحقق من أن الكود فريد في جدول الدعوات
        while (Invitation::where('invitation_code', $code)->exists()) {
            $code = Str::random(10);
        }

        return $code;
    }
}
