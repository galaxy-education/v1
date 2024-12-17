<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function getGroups()
    {
        $userId = Auth::id(); // الحصول على ID المستخدم الحالي

        // الحصول على المجموعات التي ينتمي إليها المستخدم
        $groups = Conversation::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('users')->get();

        return response()->json($groups);
    }
    public function getUsers()
{
    $users = User::all(['id', 'name']);
    return response()->json($users);
}
    public function createConversation(Request $request)
    {
        $userIds = $request->user_ids;
        sort($userIds); // ترتيب المعرفات لضمان تحديد المحادثة بشكل فريد

        $conversation = Conversation::where('type', 'private')
            ->whereHas('users', function ($query) use ($userIds) {
                $query->whereIn('user_id', $userIds);
            }, '=', count($userIds))
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'type' => 'private',
                'name' => $request->name ?? null,
            ]);

            $conversation->users()->attach($userIds);
        }

        return response()->json($conversation, 201);
    }


    public function getUserConversations(Request $request)
    {
        $user = $request->user();
        $conversations = $user->conversations()
            ->with(['users' => function ($query) use ($user) {
                $query->where('id', '!=', $user->id); // استبعاد المستخدم الحالي
            }])
            ->get();

        return response()->json($conversations);
    }
    public function sendMessage(Request $request)
    {
        // إنشاء الرسالة
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        // بث الرسالة عبر Pusher
        broadcast(new MessageSent($message));  // هذا يبث الرسالة إلى القناة المناسبة

        return response()->json($message, 201);
    }

    public function getMessages(Conversation $conversation)
    {
        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function createGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array|min:2', // يجب أن يكون هناك على الأقل مستخدمين
            'user_ids.*' => 'exists:users,id',
        ]);

        // إنشاء المحادثة
        $conversation = Conversation::create([
            'type' => 'group',
            'name' => $validated['name'], // تأكد من تخزين الاسم
        ]);

        // ربط المستخدمين بالمحادثة
        $conversation->users()->attach($validated['user_ids']);

        return response()->json($conversation, 201);
    }



}
