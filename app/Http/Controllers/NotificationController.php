<?php
namespace App\Http\Controllers;

use App\Events\TeacherRequestSubmitted;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function requestTeacherRole()
    {
        $user = Auth::user();

        if ($user->type !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'فقط الطلاب يمكنهم طلب التحويل'
            ], 400);
        }

        $notification = [
            'student_id' => $user->id,
            'student_name' => $user->name,
            'message' => "طلب {$user->name} التحول لمعلم",
            'timestamp' => now()->diffForHumans()
        ];

        // بث الإشعار للمسؤولين
        broadcast(new TeacherRequestSubmitted($notification))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الطلب بنجاح'
        ]);
    }

    public function approveTeacherRequest($studentId)
    {
        $student = User::findOrFail($studentId);

        if ($student->type !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم ليس طالباً'
            ], 400);
        }

        $student->update(['type' => 'teacher']);

        return response()->json([
            'success' => true,
            'message' => 'تم ترقية الطالب لمعلم بنجاح'
        ]);
    }
}
