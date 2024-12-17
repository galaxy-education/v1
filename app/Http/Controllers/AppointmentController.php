<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Pusher\Pusher;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('student_id', auth()->id())
            ->orWhere('teacher_id', auth()->id())
            ->with('teacher') // تحميل بيانات المعلم
            ->orderBy('start_time', 'asc')
            ->get();

        return view('appointments', compact('appointments'));
    }

    // عرض التقويم لمعلم معين
    public function show(User $teacher)
    {
        if ($teacher->type !== 'teacher') {
            abort(404, 'هذا المستخدم ليس معلماً');
        }

        return view('calendar.index', compact('teacher'));
    }

    // جلب المواعيد الخاصة بالمعلم
    public function fetchEvents(User $teacher)
    {
        // Add debugging to check if appointments are being retrieved
        \Log::info('Total appointments for teacher: ' . $teacher->appointments->count());

        $events = $teacher->appointments->map(function ($appointment) {
            // Log each appointment details
            \Log::info('Appointment details', [
                'id' => $appointment->id,
                'start' => $appointment->start_time,
                'end' => $appointment->end_time,
                'is_booked' => $appointment->is_booked
            ]);

            return [
                'id' => $appointment->id,
                'start' => $appointment->start_time,
                'end' => $appointment->end_time,
                'title' => $appointment->is_booked
                    ? 'محجوز : ' . 'من ' . \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') . ' الي ' . \Carbon\Carbon::parse($appointment->end_time)->format('g:i A')
                    : 'غير محجوز : ' . 'من ' . \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') . ' الي ' . \Carbon\Carbon::parse($appointment->end_time)->format('g:i A'),


                'color' => $appointment->is_booked ? 'red' : 'green',
            ];
        });

        return response()->json($events);
    }


    // حجز موعد
    public function book(Request $request)
    {
        try {
            // تحويل التواريخ باستخدام Carbon
            $start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end)->format('Y-m-d H:i:s');

            $appointment = Appointment::where('teacher_id', $request->teacher_id)
                ->where('start_time', $start)
                ->where('end_time', $end)
                ->first();

            if (!$appointment) {
                // إنشاء موعد جديد
                $appointment = Appointment::create([
                    'teacher_id' => $request->teacher_id,
                    'student_id' => auth()->id(),
                    'start_time' => $start,
                    'end_time' => $end,
                    'is_booked' => true,
                    'session_link' => $this->generateSessionLink(),
                ]);

                // إنشاء مواعيد متكررة لمدة عام
                $this->createRecurringAppointmentsForYear($appointment);

                // بث إشعار الجلسة
                $this->broadcastSessionCreated($appointment);

                return response()->json(['success' => 'تم حجز الموعد بنجاح!'], 200);
            }

            if ($appointment->is_booked) {
                return response()->json(['error' => 'هذا الموعد محجوز بالفعل!'], 400);
            }

            // تحديث حالة الموعد
            $appointment->update([
                'student_id' => auth()->id(),
                'is_booked' => true,
                'session_link' => $this->generateSessionLink(),
            ]);

            // بث إشعار الجلسة
            $this->broadcastSessionCreated($appointment);

            return response()->json(['success' => 'تم حجز الموعد بنجاح!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generateSessionLink()
    {
        return url('/session/' . uniqid()); // يمكن استبدال الرابط بمسار مخصص
    }

    private function broadcastSessionCreated($appointment)
    {
        $pusher = new \Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('appointments', 'session-created', [
            'appointment_id' => $appointment->id,
            'teacher_name' => $appointment->teacher->name,
            'session_link' => $appointment->session_link,
            'start_time' => $appointment->start_time,
        ]);
    }

    private function createRecurringAppointmentsForYear($appointment)
    {
        $currentStart = Carbon::parse($appointment->start_time);
        $currentEnd = Carbon::parse($appointment->end_time);

        for ($i = 1; $i <= 52; $i++) { // 52 أسبوعًا في السنة
            $nextWeekStart = $currentStart->copy()->addWeeks($i);
            $nextWeekEnd = $currentEnd->copy()->addWeeks($i);

            // تحقق إذا كان الموعد الجديد موجودًا
            $existingAppointment = Appointment::where('teacher_id', $appointment->teacher_id)
                ->where('start_time', $nextWeekStart)
                ->where('end_time', $nextWeekEnd)
                ->first();

            if (!$existingAppointment) {
                Appointment::create([
                    'teacher_id' => $appointment->teacher_id,
                    'student_id' => $appointment->student_id, // نقل الطالب للموعد المتكرر
                    'start_time' => $nextWeekStart,
                    'end_time' => $nextWeekEnd,
                    'is_booked' => true,
                    'session_link' => $this->generateSessionLink(), // توليد رابط الجلسة
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($request->appointment_id);

            if ($appointment->student_id !== auth()->id()) {
                return response()->json(['error' => 'غير مسموح لك بحذف هذا الموعد!'], 403);
            }

            // حذف جميع المواعيد المتكررة
            Appointment::where('teacher_id', $appointment->teacher_id)
                ->where('start_time', '>=', $appointment->start_time)
                ->delete();

            return response()->json(['success' => 'تم حذف الموعد وجميع المواعيد المتكررة بنجاح!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($request->appointment_id);

            if ($appointment->student_id !== auth()->id()) {
                return response()->json(['error' => 'غير مسموح لك بتعديل هذا الموعد!'], 403);
            }

            // تحويل التواريخ باستخدام Carbon
            $start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end)->format('Y-m-d H:i:s');

            // تحديث الموعد الحالي
            $appointment->update([
                'start_time' => $start,
                'end_time' => $end,
            ]);

            // تحديث جميع المواعيد المتكررة
            Appointment::where('teacher_id', $appointment->teacher_id)
                ->where('start_time', '>=', $appointment->start_time)
                ->update([
                    'start_time' => Carbon::parse($start)->addWeeks(1)->format('Y-m-d H:i:s'),
                    'end_time' => Carbon::parse($end)->addWeeks(1)->format('Y-m-d H:i:s'),
                ]);

            return response()->json(['success' => 'تم تعديل الموعد وجميع المواعيد المتكررة بنجاح!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
