@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">تقويم الحجز - المعلم {{ $teacher->name }}</h2>
        <div id="calendarr" class="rounded shadow-sm p-3 bg-light"></div>
    </div>



    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">تفاصيل الموعد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="eventStart" class="form-label">تاريخ ووقت البداية</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventEnd" class="form-label">تاريخ ووقت النهاية</label>
                            <input type="datetime-local" class="form-control" id="eventEnd" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="deleteEvent" class="btn btn-danger">حذف</button>
                    <button id="updateEvent" class="btn btn-primary">تعديل</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
            /* لون الخلفية */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            color: #343a40;
            font-weight: bold;
        }

        #calendarr {
            border: 1px solid #000000;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .fc-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .fc-button {
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-size: 14px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .fc-button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #003f7f 100%) !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .fc-event {
            background-color: #3406b1 !important;
            size: 100%;
            width: 100%;
            height: 100%;
        }

        .fc-timegrid-slot {
            border-top: 2px solid black !important;
            /* خط أسود بين التوقيتات */
        }

        .fc-timegrid-slot-lane {
            border-right: 2px solid black !important;
            /* خط فاصل عمودي بين الأعمدة */
        }

/* إضافة حدود سوداء للأعمدة (الأيام) */
.fc-col-header-cell,
.fc-daygrid-day {
    border-right: 2px solid black !important; /* خط فاصل عمودي بين الأيام */
}

/* إضافة حدود سوداء للخطوط الأفقية */
.fc-timegrid-slot {
    border-top: 2px solid black !important; /* خط أفقي بين التوقيتات */
}

/* حدود العمود الجانبي (التوقيتات) */
.fc-timegrid-slot-lane {
    border-right: 2px solid black !important; /* خط فاصل عمودي للعمود الزمني */
}

/* إضافة حدود للخلية الزمنية */
.fc-timegrid-col {
    border-left: 2px solid black !important; /* خط عمودي بين الخلايا الزمنية */
}


        .fc-event-main {
            background-color: #3406b1 !important;
            size: 500%;
            width: 100%;
            height: 100%;
            font-family: "Cairo";
            text-align: center;
            align-content: center;
            font-size: 18px;
            direction: rtl;
            border-radius: 0px;
        }

        .fc-event-available {
            background-color: #00c851 !important;
            /* لون مميز للتوافر */
        }

        .swal2-popup {
            font-size: 1rem !important;
            font-family: 'Cairo', sans-serif;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendarr');
            let eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            let eventForm = document.getElementById('eventForm');
            let deleteEventBtn = document.getElementById('deleteEvent');
            let updateEventBtn = document.getElementById('updateEvent');
            let selectedEvent;


            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // عرض الأسبوع بالكامل
                slotDuration: '00:30:00', // الفواصل الزمنية بين الفترات
                locale: 'ar', // تعريب الجدول
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay',
                },
                businessHours: {
                    // تحديد أوقات العمل
                    daysOfWeek: [1, 2, 3, 4, 5, 6, 7], // جميع أيام الأسبوع
                    startTime: '09:00', // الساعة 9 صباحًا
                    endTime: '23:00', // الساعة 11 مساءً
                },
                slotMinTime: '09:00:00', // الحد الأدنى للعرض (9 صباحًا)
                slotMaxTime: '23:00:00', // الحد الأقصى للعرض (11 مساءً)
                scrollTime: '09:00:00', // بدء التمرير من الساعة 9 صباحًا
                selectable: true, // السماح بتحديد الفترات الزمنية
                events: "{{ route('calendar.events', $teacher->id) }}", // جلب الأحداث
                eventClick: function(info) {
                    selectedEvent = info.event;
                    document.getElementById('eventStart').value = selectedEvent.start.toISOString()
                        .slice(0, 16);
                    document.getElementById('eventEnd').value = selectedEvent.end.toISOString().slice(0,
                        16);
                    eventModal.show();
                },
                eventContent: function(eventInfo) {
                    console.log(eventInfo.event);

                    let container = document.createElement('div');
                    container.innerHTML = `
                        <div>
                            ${eventInfo.event.title}
                        </div>
                    `;
                    return {
                        domNodes: [container]
                    };
                },
                select: function(info) {
                    const startDate = new Date(info.start);
                    const endDate = new Date(info.end);

                    // تحويل التاريخ والوقت إلى صيغة مناسبة
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const startTime = startDate.toLocaleTimeString('ar-EG', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const endTime = endDate.toLocaleTimeString('ar-EG', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const bookingDate = startDate.toLocaleDateString('ar-EG', options);

                    // رسالة التأكيد
                    Swal.fire({
                        title: `💡 هل تريد حجز هذا الموعد؟`,
                        html: `
                            <p>📅 ستقوم بحجز يوم: <strong>${bookingDate}</strong></p>
                            <p>⏰ من الساعة: <strong>${startTime}</strong> إلى الساعة: <strong>${endTime}</strong></p>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '✔️ نعم، احجز',
                        cancelButtonText: '❌ إلغاء',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const start = startDate.toISOString().slice(0, 19).replace('T',
                                ' ');
                            const end = endDate.toISOString().slice(0, 19).replace('T', ' ');

                            fetch("{{ route('calendar.book') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify({
                                        start: start,
                                        end: end,
                                        teacher_id: {{ $teacher->id }},
                                    }),
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            throw new Error(err.error ||
                                                'حدث خطأ غير متوقع');
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire('✅ تم', data.success, 'success');
                                    calendar.refetchEvents();
                                })
                                .catch(error => {
                                    Swal.fire('❌ خطأ', error.message, 'error');
                                });
                        }
                    });
                },
            });

            calendar.render();
            deleteEventBtn.addEventListener('click', function() {
                fetch("{{ route('calendar.delete') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            appointment_id: selectedEvent.id,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('✅ تم', data.success, 'success');
                            selectedEvent.remove();
                            eventModal.hide();
                        } else {
                            throw new Error(data.error);
                        }
                    })
                    .catch(error => {
                        Swal.fire('❌ خطأ', error.message, 'error');
                    });
            });

            // Update Event
            updateEventBtn.addEventListener('click', function() {
                const start = document.getElementById('eventStart').value;
                const end = document.getElementById('eventEnd').value;

                fetch("{{ route('calendar.edit') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            appointment_id: selectedEvent.id,
                            start: start,
                            end: end,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('✅ تم', data.success, 'success');
                            selectedEvent.setStart(start);
                            selectedEvent.setEnd(end);
                            eventModal.hide();
                        } else {
                            throw new Error(data.error);
                        }
                    })
                    .catch(error => {
                        Swal.fire('❌ خطأ', error.message, 'error');
                    });
            });
        });
    </script>
@endsection
