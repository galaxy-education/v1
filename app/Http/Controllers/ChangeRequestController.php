<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeRequest;
use App\Models\User;
use Pusher\Pusher;

class ChangeRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $changeRequest = ChangeRequest::create([
            'user_id' => $request->user_id,
        ]);

        // إرسال الإشعار للإداريين عبر Pusher
        $pusher = new Pusher('df8ed047a96642e1c832', '811f1b6d75749c2eb4f1', '1899492', [
            'cluster' => 'eu',
            'useTLS' => true,
        ]);

        $pusher->trigger('admin-channel', 'change-request', [
            'id' => $changeRequest->id,
            'user_id' => $changeRequest->user_id,
        ]);

        return response()->json(['success' => true]);
    }

    public function approve($id)
    {
        $changeRequest = ChangeRequest::findOrFail($id);
        $user = User::findOrFail($changeRequest->user_id);

        $user->update(['type' => 'teacher']);
        $changeRequest->update(['status' => 'approved']);

        // إرسال إشعار إلى صاحب الطلب
        $this->sendUserNotification($user->id, 'تمت الموافقة على طلبك لتغيير النوع إلى معلم.');

        return response()->json(['success' => true]);
    }

    public function reject($id)
    {
        $changeRequest = ChangeRequest::findOrFail($id);
        $user = User::findOrFail($changeRequest->user_id);

        $changeRequest->update(['status' => 'rejected']);

        // إرسال إشعار إلى صاحب الطلب
        $this->sendUserNotification($user->id, 'تم رفض طلبك لتغيير النوع إلى معلم.');

        return response()->json(['success' => true]);
    }

    private function sendUserNotification($userId, $message)
    {
        $pusher = new Pusher('df8ed047a96642e1c832', '811f1b6d75749c2eb4f1', '1899492', [
            'cluster' => 'eu',
            'useTLS' => true,
        ]);

        $pusher->trigger("user-channel-$userId", 'status-update', [
            'message' => $message,
        ]);
    }
}
