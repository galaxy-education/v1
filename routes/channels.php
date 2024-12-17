<?php

use App\Models\Appointment;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('admin-channel', function ($user) {
    return $user->type === 'admin';
});





Broadcast::channel('video-session.{id}', function ($user, $id) {
    return true; // تحقق من الصلاحيات إذا لزم الأمر
});


Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // تحقق من أن المستخدم هو جزء من المحادثة المحددة
    $conversation = \App\Models\Conversation::find($conversationId);
    if ($conversation && $conversation->users->contains($user->id)) {
        return true; // السماح للمستخدم بالانضمام
    }

    return false; // رفض الوصول إذا كان المستخدم ليس جزءًا من المحادثة
});
