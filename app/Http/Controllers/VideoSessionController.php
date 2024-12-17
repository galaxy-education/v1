<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Appointment;

class VideoSessionController extends Controller
{
    public function showSession($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure only the student or teacher can access the session
        if (auth()->id() !== $appointment->student_id &&
            auth()->id() !== $appointment->teacher_id) {
            abort(403, 'Unauthorized access');
        }

        return view('session', compact('appointment'));
    }

    public function signal(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        if (auth()->id() !== $appointment->student_id && auth()->id() !== $appointment->teacher_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $type = $request->type;
        $data = $request->except('type');

        try {
            $pusher = new \Pusher\Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_APP_CLUSTER')]
            );

            $pusher->trigger("video-session-$id", $type, $data);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
