<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>

<head>

    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <style>
        body {
            font-family: "Cairo", serif !important;

        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="shortcut icon" href="{{ asset('dash/assets/images/logo/favicon.png') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/bootstrap.min.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/file-upload.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/plyr.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.css" rel="stylesheet">

    <!-- full calendar -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/full-calendar.css') }}">
    <!-- jquery Ui -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/jquery-ui.css') }}">
    <!-- editor quill Ui -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/editor-quill.css') }}">
    <!-- apex charts Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/apexcharts.css') }}">
    <!-- calendar Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/calendar.css') }}">
    <!-- jvector map Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/jquery-jvectormap-2.0.5.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/js/app.js') <!-- Vite will inject the JS file -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <aside class="sidebar">
        <!-- sidebar close btn -->
        <button type="button"
            class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i
                class="ph ph-x"></i></button>
        <!-- sidebar close btn -->

        <a href="index.html"
            class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
            <img src="assets/images/logo/logo.png" alt="Logo">
        </a>

        <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
            <div class="p-20 pt-10">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu__item">
                        <a href="{{ route('profile.setup') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-house"></i></span>
                            <span class="text">الرئيسية</span>
                        </a>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('reports') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-chart-line"></i></span>
                            <span class="text">التقارير</span>
                        </a>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('file.explorer') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-folder-open"></i></span>
                            <span class="text">متصفح الملفات</span>
                        </a>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('courses.index') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-book"></i></span>
                            <span class="text">الكورسات</span>
                        </a>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('schools.index') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-graduation-cap"></i></span>
                            <span class="text">المدارس و المراحل التعليمية</span>
                        </a>
                    </li>


                </ul>
            </div>
            {{-- @if (Auth::user()->type == 'student')
                <div class="p-20 pt-80">
                    <div class="bg-main-50 p-20 pt-0 rounded-16 text-center mt-74">
                        <span
                            class="border border-5 bg-white mx-auto border-primary-50 w-114 h-114 rounded-circle flex-center text-success-600 text-2xl translate-n74">
                            <img src="assets/images/icons/certificate.png" alt="" class="centerised-img">
                        </span>
                        <div class="mt-n74">
                            <h5 class="mb-4 mt-22" style="font-family: 'Cairo">كن معلم الان</h5>
                            <p class="">انضم الي اكثر من
                                {{ App\Models\User::where('type', 'teacher')->count() }}
                                معلم من جميع انحاء الوطن العربي
                            </p>
                            <button id="request-change" class="btn btn-primary">طلب تغيير إلى معلم</button>



                        </div>
                    </div>
                </div>
            @endif --}}
        </div>

    </aside>
    <div class="dashboard-main-wrapper">
        <div class="top-navbar flex-between gap-16">

            <div class="flex-align gap-16">
                <!-- Toggle Button Start -->
                <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i
                        class="ph ph-list"></i></button>
                <!-- Toggle Button End -->

                <form action="#" class="w-350 d-sm-block d-none">
                    <div class="position-relative">
                        <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none"><i
                                class="ph ph-magnifying-glass"></i></button>
                        <input type="text"
                            class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15"
                            placeholder="Search...">
                    </div>
                </form>
            </div>

            <div class="flex-align gap-16">
                <div class="flex-align gap-8">
                    <!-- Notification Start -->
                    <div class="dropdown">
                        <button
                            class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="position-relative">
                                <i class="ph ph-bell"></i>
                                <span class="alarm-notify position-absolute end-0"></span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="py-8 px-24 bg-main-600">
                                        <div class="flex-between">
                                            <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                                            <div class="flex-align gap-12">
                                                <button type="button"
                                                    class="bg-white rounded-6 text-sm px-8 py-2 hover-text-primary-600">
                                                    New </button>
                                                <button type="button"
                                                    class="close-dropdown hover-scale-1 text-xl text-white"><i
                                                        class="ph ph-x"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-24 max-h-270 overflow-y-auto scroll-sm" id="notfication">

                                    </div>


                                    <script>
                                        // طلب الإذن لتفعيل الإشعارات
                                        if ('Notification' in window && Notification.permission !== 'granted') {
                                            Notification.requestPermission().then(permission => {
                                                if (permission === 'granted') {
                                                    console.log('تم السماح بالإشعارات!');
                                                } else {
                                                    console.log('تم رفض الإشعارات!');
                                                }
                                            });
                                        }

                                        document.getElementById('request-change').addEventListener('click', function() {
                                            const userId = {{ auth()->user()->id }};

                                            fetch('{{ route('change-request.store') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({
                                                        user_id: userId
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        alert('تم إرسال الطلب بنجاح.');
                                                    } else {
                                                        alert('حدث خطأ أثناء إرسال الطلب.');
                                                    }
                                                });
                                        });
                                    </script>
                                    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        // تمرير نوع المستخدم و ID من Laravel
                                        const userType = "{{ auth()->user()->type }}";
                                        const userId = "{{ auth()->user()->id }}";

                                        // إعداد Pusher
                                        const pusher = new Pusher('df8ed047a96642e1c832', {
                                            cluster: 'eu'
                                        });

                                        // إذا كان المستخدم من نوع admin
                                        if (userType === 'admin') {
                                            const adminChannel = pusher.subscribe('admin-channel');

                                            // استقبال إشعارات طلبات التغيير
                                            adminChannel.bind('change-request', function(data) {
                                                const notificationContainer = document.querySelector('#notfication');

                                                // إنشاء إشعار جديد
                                                const notification = document.createElement('div');
                                                notification.classList.add('d-flex', 'align-items-start', 'gap-12', 'mb-12');
                                                notification.innerHTML = `
                <img src="assets/images/thumbs/notification-img2.png" alt=""
                    class="w-48 h-48 rounded-circle object-fit-cover">
                <div>
                    <a href="#"
                        class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600 text-line-2">
                        طلب تغيير النوع: المستخدم <b>${data.user_id}</b> يريد أن يصبح معلم.
                    </a>
                    <div class="mt-8">
                        <button onclick="approveRequest(${data.id}, ${data.user_id})" class="btn btn-success btn-sm">موافقة</button>
                        <button onclick="rejectRequest(${data.id}, ${data.user_id})" class="btn btn-danger btn-sm">رفض</button>
                    </div>
                    <span class="text-gray-200 text-13 mt-4 d-block">تم الإرسال الآن</span>
                </div>
            `;

                                                notificationContainer.prepend(notification);

                                                // عرض SweetAlert Notification
                                                Swal.fire({
                                                    title: 'طلب جديد لتغيير النوع',
                                                    text: `المستخدم ${data.user_id} يريد أن يصبح معلم.`,
                                                    icon: 'info',
                                                    showCancelButton: false,
                                                    confirmButtonText: 'موافق'
                                                });

                                                // عرض Push Notification
                                                if ('Notification' in window && Notification.permission === 'granted') {
                                                    const pushNotification = new Notification('طلب جديد لتغيير النوع', {
                                                        body: `المستخدم ${data.user_id} يريد أن يصبح معلم.`,
                                                        icon: 'assets/images/thumbs/notification-img2.png'
                                                    });

                                                    pushNotification.onclick = function() {
                                                        window.focus();
                                                    };
                                                }
                                            });
                                        }

                                        // الاشتراك في قناة المستخدم
                                        const userChannel = pusher.subscribe(`user-channel-${userId}`);

                                        // استقبال إشعار الموافقة أو الرفض
                                        userChannel.bind('status-update', function(data) {
                                            const notificationContainer = document.querySelector('#notfication');

                                            // إنشاء إشعار جديد
                                            const notification = document.createElement('div');
                                            notification.classList.add('d-flex', 'align-items-start', 'gap-12', 'mb-12');
                                            notification.innerHTML = `
            <div class="text-gray-300">
                <b>${data.message}</b>
                <span class="text-gray-200 text-13 mt-4 d-block">تم التحديث الآن</span>
            </div>
        `;

                                            notificationContainer.prepend(notification);

                                            // عرض SweetAlert Notification
                                            Swal.fire({
                                                title: 'إشعار جديد',
                                                text: data.message,
                                                icon: data.message.includes('تمت الموافقة') ? 'success' : 'error',
                                                showCancelButton: false,
                                                confirmButtonText: 'موافق'
                                            });

                                            // عرض Push Notification
                                            if ('Notification' in window && Notification.permission === 'granted') {
                                                const pushNotification = new Notification('إشعار جديد', {
                                                    body: data.message,
                                                    icon: 'assets/images/thumbs/notification-img2.png'
                                                });

                                                pushNotification.onclick = function() {
                                                    window.focus();
                                                };
                                            }
                                        });

                                        // الموافقة على الطلب
                                        function approveRequest(requestId, userId) {
                                            fetch(`{{ route('change-request.approve', ':id') }}`.replace(':id', requestId), {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    }
                                                })
                                                .then(response => response.json())
                                                .then(() => {
                                                    Swal.fire({
                                                        title: 'تمت الموافقة',
                                                        text: 'تمت الموافقة على الطلب بنجاح.',
                                                        icon: 'success',
                                                        confirmButtonText: 'موافق'
                                                    });
                                                });
                                        }

                                        // رفض الطلب
                                        function rejectRequest(requestId, userId) {
                                            fetch(`{{ route('change-request.reject', ':id') }}`.replace(':id', requestId), {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    }
                                                })
                                                .then(response => response.json())
                                                .then(() => {
                                                    Swal.fire({
                                                        title: 'تم الرفض',
                                                        text: 'تم رفض الطلب بنجاح.',
                                                        icon: 'error',
                                                        confirmButtonText: 'موافق'
                                                    });
                                                });
                                        }

                                        // طلب الإذن باستخدام Push Notification إذا لم يكن موجودًا
                                        if ('Notification' in window && Notification.permission !== 'granted') {
                                            Notification.requestPermission();
                                        }
                                    </script>






                                    <a href="#"
                                        class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline">
                                        View All </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notification Start -->

                    <!-- Language Start -->
                    <div class="dropdown">
                        <button
                            class="text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph ph-globe"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                <div class="card-body">
                                    <div class="max-h-270 overflow-y-auto scroll-sm pe-8">
                                        <!-- Arabic Option -->
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0 mb-16">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="arabic">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="https://user-images.githubusercontent.com/48198054/54481207-c3b57000-4842-11e9-8420-20e3b82f4b82.png"
                                                        alt=""
                                                        class="w-32-px h-32-px border border-gray-100 rounded-circle flex-shrink-0"
                                                        width="40">
                                                    <span class="text-15 fw-semibold mb-0">Arabic</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="arabic" onclick="changeLanguage('ar')"
                                                {{ app()->getLocale() === 'ar' ? 'checked' : '' }}>
                                        </div>
                                        <!-- English Option -->
                                        <div
                                            class="form-check form-radio d-flex align-items-center justify-content-between ps-0 mb-16">
                                            <label
                                                class="ps-0 form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="english">
                                                <span
                                                    class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-8">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Flag_of_the_United_Kingdom_%281-2%29.svg/1200px-Flag_of_the_United_Kingdom_%281-2%29.svg.png"
                                                        alt=""
                                                        class="w-32-px h-32-px border border-gray-100 rounded-circle flex-shrink-0"
                                                        width="40">
                                                    <span class="text-15 fw-semibold mb-0">English</span>
                                                </span>
                                            </label>
                                            <input class="form-check-input" type="radio" name="language"
                                                id="english" onclick="changeLanguage('en')"
                                                {{ app()->getLocale() === 'en' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function changeLanguage(lang) {
                                let url = lang === 'ar' ? "{{ LaravelLocalization::getLocalizedURL('ar') }}" :
                                    "{{ LaravelLocalization::getLocalizedURL('en') }}";
                                window.location.href = url;
                            }
                        </script>
                    </div>

                    <!-- Language Start -->


                    <div class="dropdown">
                        <button
                            class="text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph ph-wallet"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                <div class="card-header bg-primary text-white">
                                    <i class="bi bi-wallet me-2"></i> رصيدك الحالي
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        {{ Auth::user()->walt ? Auth::user()->walt->price : 0 }} ج.م
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- User Profile Start -->
                <div class="dropdown">
                    <button
                        class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="position-relative">
                            <img src="{{ Storage::url(Auth::user()->profile->photo ?? 'default.jpg') }}"
                                alt="Image" class="h-32 w-32 rounded-circle">
                            <span
                                class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                            <div class="card-body">
                                <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                    <img src="{{ Storage::url(Auth::user()->profile->photo ?? 'default.jpg') }}"
                                        alt="" class="w-54 h-54 rounded-circle">
                                    <div class="">
                                        <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                                        <p class="fw-medium text-13 text-gray-200">{{ Auth::user()->email }}</p>
                                        <p class="fw-medium text-13 text-gray-200">{{ Auth::user()->phone_number }}
                                        </p>
                                    </div>
                                </div>
                                <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">



                                    <li class="pt-8 ">
                                        <a href=""
                                            class="py-12 text-15 px-20 hover-bg-danger-50 text-gray-300 hover-text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-danger-600 d-flex"><i
                                                    class="ph ph-sign-out"></i></span>
                                            <span class="text">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Start -->

            </div>
        </div>


        <div class="dashboard-body">

            @yield('content')
        </div>
        <div class="dashboard-footer">
            <div class="flex-between flex-wrap gap-16">
                <p class="text-gray-300 text-13 fw-normal"> &copy; Copyright Optec 2025, All Right Reserverd</p>
                <div class="flex-align flex-wrap gap-16">
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">Documentation</a>
                    <a href="#"
                        class="text-gray-300 text-13 fw-normal hover-text-main-600 hover-text-decoration-underline">Support</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Floating Button -->
    <x-report-form />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- Jquery js -->
    <script src="{{ asset('dash/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- resources/views/multi-step-form.blade.php -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.js"></script>

    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('dash/assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- Phosphor Js -->
    <script src="{{ asset('dash/assets/js/phosphor-icon.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('dash/assets/js/file-upload.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('dash/assets/js/plyr.js') }}"></script>
    <!-- dataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- full calendar -->
    <script src="{{ asset('dash/assets/js/full-calendar.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/assets/js/jquery-ui.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/assets/js/editor-quill.js') }}"></script>
    <!-- apex charts -->
    <script src="{{ asset('dash/assets/js/apexcharts.min.js') }}"></script>
    <!-- Calendar Js -->
    <script src="{{ asset('dash/assets/js/calendar.js') }}"></script>
    <!-- jvectormap Js -->
    <script src="{{ asset('dash/assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <!-- jvectormap world Js -->
    <script src="{{ asset('dash/assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- main js -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.1/dist/lucide.min.js"></script>

    <script src="{{ asset('dash/assets/js/main.js') }}"></script>
    <script>
        function createChart(chartId, chartColor) {

            let currentYear = new Date().getFullYear();

            var options = {
                series: [{
                    name: 'series1',
                    data: [18, 25, 22, 40, 34, 55, 50, 60, 55, 65],
                }, ],
                chart: {
                    type: 'area',
                    width: 80,
                    height: 42,
                    sparkline: {
                        enabled: true // Remove whitespace
                    },

                    toolbar: {
                        show: false
                    },
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 1,
                    colors: [chartColor],
                    lineCap: 'round'
                },
                grid: {
                    show: true,
                    borderColor: 'transparent',
                    strokeDashArray: 0,
                    position: 'back',
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    row: {
                        colors: undefined,
                        opacity: 0.5
                    },
                    column: {
                        colors: undefined,
                        opacity: 0.5
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                },
                fill: {
                    type: 'gradient',
                    colors: [chartColor], // Set the starting color (top color) here
                    gradient: {
                        shade: 'light', // Gradient shading type
                        type: 'vertical', // Gradient direction (vertical)
                        shadeIntensity: 0.5, // Intensity of the gradient shading
                        gradientToColors: [`${chartColor}00`], // Bottom gradient color (with transparency)
                        inverseColors: false, // Do not invert colors
                        opacityFrom: .5, // Starting opacity
                        opacityTo: 0.3, // Ending opacity
                        stops: [0, 100],
                    },
                },
                // Customize the circle marker color on hover
                markers: {
                    colors: [chartColor],
                    strokeWidth: 2,
                    size: 0,
                    hover: {
                        size: 8
                    }
                },
                xaxis: {
                    labels: {
                        show: false
                    },
                    categories: [`Jan ${currentYear}`, `Feb ${currentYear}`, `Mar ${currentYear}`, `Apr ${currentYear}`,
                        `May ${currentYear}`, `Jun ${currentYear}`, `Jul ${currentYear}`, `Aug ${currentYear}`,
                        `Sep ${currentYear}`, `Oct ${currentYear}`, `Nov ${currentYear}`, `Dec ${currentYear}`
                    ],
                    tooltip: {
                        enabled: false,
                    },
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
            chart.render();
        }

        // Call the function for each chart with the desired ID and color
        createChart('complete-course', '#2FB2AB');
        createChart('earned-certificate', '#27CFA7');
        createChart('course-progress', '#6142FF');
        createChart('community-support', '#FA902F');


        // =========================== Double Line Chart Start ===============================
        function createLineChart(chartId, chartColor) {
            var options = {
                series: [{
                        name: 'Study',
                        data: [3.6, 1.8, 3.8, 0, 2.4, 0.6, 8, 1.2, 2.8, 2.3, 4, 2],
                    },
                    {
                        name: 'Test',
                        data: [0.2, 4, 0, 6, 0.6, 4, 4, 8, 2.1, 5.6, 1.8, 3.6],
                    },
                ],
                chart: {
                    type: 'line',
                    width: '100%',
                    height: 350,
                    sparkline: {
                        enabled: false // Remove whitespace
                    },
                    toolbar: {
                        show: false
                    },
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                colors: ['#3D7FF9', chartColor], // Set the color of the series
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    colors: ["#3D7FF9", chartColor],
                    lineCap: 'round',
                },
                grid: {
                    show: true,
                    borderColor: '#E6E6E6',
                    strokeDashArray: 3,
                    position: 'back',
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    row: {
                        colors: undefined,
                        opacity: 0.5
                    },
                    column: {
                        colors: undefined,
                        opacity: 0.5
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                },
                // Customize the circle marker color on hover
                markers: {
                    colors: ["#3D7FF9", chartColor],
                    strokeWidth: 3,
                    size: 0,
                    hover: {
                        size: 8
                    }
                },
                xaxis: {
                    labels: {
                        show: false
                    },
                    categories: [`Jan`, `Feb`, `Mar`, `Apr`, `May`, `Jun`, `Jul`, `Aug`, `Sep`, `Oct`, `Nov`, `Dec`],
                    tooltip: {
                        enabled: false,
                    },
                    labels: {
                        formatter: function(value) {
                            return value;
                        },
                        style: {
                            fontSize: "14px"
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return "$" + value + "Hr";
                        },
                        style: {
                            fontSize: "14px"
                        }
                    },
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
                legend: {
                    show: false,
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetX: -10,
                    offsetY: -0
                }
            };

            var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
            chart.render();
        }
        createLineChart('doubleLineChart', '#27CFA7');
        // =========================== Double Line Chart End ===============================

        // ============================ Donut Chart Start ==========================
        var options = {
            series: [65.2, 25, 9.8],
            chart: {
                height: 270,
                type: 'donut',
            },
            colors: ['#3D7FF9', '#27CFA7', '#EA5455'],
            enabled: true, // Enable data labels
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + '%';
            },
            dropShadow: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%' // Fixed slice width
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: "100%"
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                position: 'right',
                offsetY: 0,
                height: 230,
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#activityDonutChart"), options);
        chart.render();
        // ============================ Donut Chart End ==========================
    </script>


    <script>
        // ========================== Export Js Start ==============================
        document.getElementById('exportOptions').addEventListener('change', function() {
            const format = this.value;
            const table = document.getElementById('assignmentTable');
            let data = [];
            const headers = [];

            // Get the table headers
            table.querySelectorAll('thead th').forEach(th => {
                headers.push(th.innerText.trim());
            });

            // Get the table rows
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = {};
                tr.querySelectorAll('td').forEach((td, index) => {
                    row[headers[index]] = td.innerText.trim();
                });
                data.push(row);
            });

            if (format === 'csv') {
                downloadCSV(data);
            } else if (format === 'json') {
                downloadJSON(data);
            }
        });

        function downloadCSV(data) {
            const csv = data.map(row => Object.values(row).join(',')).join('\n');
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'students.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function downloadJSON(data) {
            const json = JSON.stringify(data, null, 2);
            const blob = new Blob([json], {
                type: 'application/json'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'students.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
        // ========================== Export Js End ==============================

        // Table Header Checkbox checked all js Start
        $('#selectAll').on('change', function() {
            $('.form-check .form-check-input').prop('checked', $(this).prop('checked'));
        });

        // Data Tables
        new DataTable('#assignmentTable', {
            searching: false,
            lengthChange: false,
            info: false, // Bottom Left Text => Showing 1 to 10 of 12 entries
            paging: false,
            "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 6]
                } // Disables sorting on the 7th column (index 6)
            ]
        });
    </script>

</body>

</html>
