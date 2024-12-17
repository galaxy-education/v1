@extends('layouts.dashboard')
@section('content')
    @if (Auth::user()->type == 'student' && !Auth::user()->profile)
        <style>
            :root {
                --primary-color: #4361ee;
                --secondary-color: #3f37c9;
                --font-family: 'Cairo', sans-serif;
            }

            body {
                background-color: #f8f9fa;
                font-family: var(--font-family);
            }

            .step {
                opacity: 0;
                display: none;
                transform: translateX(50px);
                transition: all 0.3s ease-in-out;
            }

            .step.active {
                opacity: 1;
                display: block;
                transform: translateX(0);
            }

            .form-container {
                max-width: 600px;
                margin: 2rem auto;
                padding: 2.5rem;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                background: white;
            }

            .steps-indicator {
                display: flex;
                justify-content: center;
                margin-bottom: 2rem;
                position: relative;
            }

            .step-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #fff;
                border: 2px solid #dee2e6;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: #6c757d;
                position: relative;
                z-index: 2;
                transition: all 0.3s ease;
            }

            .step-icon.active {
                background: var(--primary-color);
                border-color: var(--primary-color);
                color: white;
            }

            .step-icon.completed {
                background: var(--primary-color);
                border-color: var(--primary-color);
                color: white;
            }

            .step-connector {
                flex: 1;
                height: 2px;
                background: #dee2e6;
                margin: 20px 10px;
            }

            .step-connector.active {
                background: var(--primary-color);
            }

            .form-control {
                padding: 0.75rem 1rem;
                border-radius: 10px;
                border: 2px solid #eee;
                margin-bottom: 1.25rem;
                transition: all 0.3s ease;
                font-family: var(--font-family);
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: none;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                font-family: var(--font-family);
            }

            .btn-primary {
                background: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-primary:hover {
                background: var(--secondary-color);
                border-color: var(--secondary-color);
            }

            .btn-secondary {
                background: #e9ecef;
                border-color: #e9ecef;
                color: #495057;
            }

            .btn-secondary:hover {
                background: #dee2e6;
                border-color: #dee2e6;
                color: #212529;
            }

            .btn-successs {
                background: #38b000;
                border-color: #38b000;
            }

            .step-title {
                color: #2c3e50;
                margin-bottom: 1.75rem;
                font-weight: 700;
                font-size: 1.5rem;
                font-family: var(--font-family);
            }

            .btn-group {
                display: flex;
                gap: 1rem;
                margin-top: 2rem;
            }
        </style>



        <div class="container">
            <div class="form-container">
                <!-- Step Indicators -->
                <div class="steps-indicator">
                    <div class="step-icon active" id="icon1">
                        <i class="ph ph-user-plus"></i> <!-- Phosphor icon for user-plus -->
                    </div>
                    <div class="step-connector" id="connector1"></div>
                    <div class="step-icon" id="icon2">
                        <i class="ph ph-info"></i> <!-- Phosphor icon for info -->
                    </div>
                    <div class="step-connector" id="connector2"></div>
                    <div class="step-icon" id="icon3">
                        <i class="ph ph-code"></i> <!-- Phosphor icon for code -->
                    </div>
                </div>


                <form id="multiStepForm" class="needs-validation" novalidate>
                    @csrf

                    <!-- Step 1 -->
                    <div class="step active" id="step1">
                        <h3 class="step-title">الخطوة 1: تعديل رقم الهاتف</h3>
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" placeholder="أدخل رقم الهاتف"
                                required>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary w-100" onclick="nextStep()">التالي</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step" id="step2">
                        <h3 class="step-title">الخطوة 2: تعديل البيانات الشخصية</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" name="about" placeholder="عن نفسك">
                            <input type="tel" class="form-control" name="baba_phone" placeholder="رقم هاتف الوالد">
                            <input type="text" class="form-control" name="education_levels"
                                placeholder="مستويات التعليم">
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">السابق</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">التالي</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step" id="step3">
                        <h3 class="step-title">الخطوة 3: إضافة كود الدعوة</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" name="invitation_code" placeholder="أدخل كود الدعوة">
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">السابق</button>
                            <button type="submit" class="btn btn-successs">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            let currentStep = 1;
            const totalSteps = 3;

            function updateStepIndicators(step) {
                // Update icons
                for (let i = 1; i <= totalSteps; i++) {
                    const icon = document.getElementById(`icon${i}`);
                    if (i < step) {
                        icon.classList.add('completed');
                        icon.classList.remove('active');
                    } else if (i === step) {
                        icon.classList.add('active');
                        icon.classList.remove('completed');
                    } else {
                        icon.classList.remove('completed', 'active');
                    }
                }

                // Update connectors
                for (let i = 1; i < totalSteps; i++) {
                    const connector = document.getElementById(`connector${i}`);
                    if (i < step) {
                        connector.classList.add('active');
                    } else {
                        connector.classList.remove('active');
                    }
                }
            }

            function showStep(step) {
                document.querySelectorAll('.step').forEach(el => {
                    el.classList.remove('active');
                });

                const targetStep = document.getElementById(`step${step}`);
                setTimeout(() => {
                    targetStep.classList.add('active');
                }, 50);

                updateStepIndicators(step);
            }

            function nextStep() {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }

            function prevStep() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            }

            document.getElementById('multiStepForm').onsubmit = function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                Swal.fire({
                    title: 'جاري الحفظ...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post("{{ route('user.updateProfile') }}", formData, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحفظ بنجاح',
                            text: response.data.message,
                            confirmButtonText: 'تم'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        let errorMessage = 'حدث خطأ غير متوقع';

                        if (error.response) {
                            errorMessage = error.response.data.message || 'حدث خطأ في الخادم';
                        } else if (error.request) {
                            errorMessage = 'لم يتم الحصول على استجابة من الخادم';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: errorMessage,
                            confirmButtonText: 'حسناً'
                        });
                    });
            };

            // Initialize form
            showStep(currentStep);
        </script>
    @elseif (Auth::user()->type == 'student' && Auth::user()->profile)
        <div class="row gy-4">
            <div class="col-xxl-8">
                <div class="card h-100">
                    <div class="card-body grettings-box-two position-relative z-1 p-0">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="grettings-box-two__content">
                                    <h2 class="fw-medium mb-0 flex-align gap-10">Hi, {{ Auth::user()->name }} <img
                                            src="{{ asset('dash/assets/images/icons/wave-hand.png') }}" alt="">
                                    </h2>
                                    <h2 class="fw-medium mb-16">What do you want to learn today with your partner?</h2>
                                    <p class="text-15 text-gray-400">Discover courses, track progress, and achieve your
                                        learning goods seamlessly.</p>

                                </div>
                            </div>
                            <div class="col-lg-6 d-md-block d-none mt-auto">
                                <img src="{{ 'dash/assets/images/thumbs/gretting-thumb.png' }}" alt="">
                            </div>
                        </div>
                        <img src="'{{ 'dash/assets/images/bg/star-shape.png' }}"
                            class="position-absolute start-0 top-0 w-100 h-100 z-n1 object-fit-contain" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <!-- Widgets Start -->
                <div class="row gy-4">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-between gap-8 mb-24">
                                    <span
                                        class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl"><i
                                            class="ph-fill ph-graduation-cap"></i></span>
                                    <div id="complete-course" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>

                                <h4 class="mb-2">155+</h4>
                                <span class="text-gray-300">Completed Courses</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-between gap-8 mb-24">
                                    <span
                                        class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl"><i
                                            class="ph-fill ph-graduation-cap"></i></span>
                                    <div id="earned-certificate" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>

                                <h4 class="mb-2">39+</h4>
                                <span class="text-gray-300">Earned Certificate</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-between gap-8 mb-24">
                                    <span
                                        class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl"><i
                                            class="ph-fill ph-certificate"></i></span>
                                    <div id="course-progress" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>

                                <h4 class="mb-2">25+</h4>
                                <span class="text-gray-300">Course in Progress</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex-between gap-8 mb-24">
                                    <span
                                        class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i
                                            class="ph-fill ph-users-four"></i></span>
                                    <div id="community-support" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>

                                <h4 class="mb-2">18k+</h4>
                                <span class="text-gray-300">Community Support</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Widgets End -->
            </div>
        </div>


        <div class="mt-24">
            <div class="row gy-4">

                <div class="col-xxl-6">
                    <!-- Top Course Start -->
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-20 flex-between flex-wrap gap-8">
                                <h4 class="mb-0">Study Overview</h4>
                                <div class="flex-align gap-16 flex-wrap">
                                    <div class="flex-align flex-wrap gap-16">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="w-8 h-8 rounded-circle bg-main-600"></span>
                                            <span class="text-13 text-gray-600">Design</span>
                                        </div>
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="w-8 h-8 rounded-circle bg-main-two-600"></span>
                                            <span class="text-13 text-gray-600">Development</span>
                                        </div>
                                    </div>
                                    <select class="form-select form-control text-13 px-8 pe-24 py-8 rounded-8 w-auto">
                                        <option value="1">Yearly</option>
                                        <option value="1">Monthly</option>
                                        <option value="1">Weekly</option>
                                        <option value="1">Today</option>
                                    </select>
                                </div>
                            </div>

                            <div id="doubleLineChart" class="tooltip-style y-value-left"></div>

                        </div>
                    </div>
                    <!-- Top Course End -->
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <!-- Progress Bar Start -->
                    <div class="card h-100">
                        <div class="card-header border-bottom border-gray-100 flex-between flex-wrap gap-8">
                            <h5 class="mb-0">Progress Statistics</h5>
                            <div class="dropdown flex-shrink-0">
                                <button class="text-gray-400 text-xl d-flex rounded-4" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ph-fill ph-dots-three-outline"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                    <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                        <div class="card-body p-12">
                                            <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                <ul>
                                                    <li class="mb-0">
                                                        <a href="students.html"
                                                            class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 w-100 rounded-8 fw-normal text-xs d-block text-start">
                                                            <span class="text"> <i class="ph ph-user me-4"></i>
                                                                View</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="">
                                <span class="text-gray-200 text-lg mb-12 mt-10 d-block text-center">Total
                                    activity</span>
                                <h1 class="text-48 fw-medium mb-12 text-center"> 65.2%</h1>
                                <div class="flex-between flex-wrap">
                                    <div class="d-flex gap-8 mt-12 flex-column w-50-perc pe-8">
                                        <div class="progress w-100 bg-main-100 rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="32" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-600 rounded-pill" style="width: 32%">
                                            </div>
                                        </div>
                                        <span class="text-neutral-600 flex-shrink-0 text-13 fw-medium">32%</span>
                                    </div>
                                    <div class="d-flex gap-8 mt-12 flex-column w-50-perc ps-8">
                                        <div class="progress w-100 bg-main-two-100 rounded-pill h-4" role="progressbar"
                                            aria-label="Basic example" aria-valuenow="80" aria-valuemin="0"
                                            aria-valuemax="100">
                                            <div class="progress-bar bg-main-two-600 rounded-pill" style="width: 80%">
                                            </div>
                                        </div>
                                        <span class="text-neutral-600 flex-shrink-0 text-13 fw-medium">80%</span>
                                    </div>
                                </div>

                                <!-- Progress Card Start -->
                                <div class="mt-20">
                                    <div class="bg-primary-50 rounded-16 p-12 flex-between flex-wrap gap-8 mb-16">
                                        <div class="flex-align gap-16">
                                            <span
                                                class="w-48 h-48 rounded-8 flex-center text-xl bg-primary-600 text-white"><i
                                                    class="ph ph-calendar-dots"></i></span>
                                            <h2 class="mb-0 fw-medium text-primary-600">25</h2>
                                        </div>
                                        <span
                                            class="px-16 py-4 rounded-pill bg-white border border-primary-600 text-primary-600 fw-medium">In
                                            Progress</span>
                                    </div>
                                    <div class="bg-success-50 rounded-16 p-12 flex-between flex-wrap gap-8 mb-0">
                                        <div class="flex-align gap-16">
                                            <span
                                                class="w-48 h-48 rounded-8 flex-center text-xl bg-success-600 text-white"><i
                                                    class="ph ph-calendar-dots"></i></span>
                                            <h2 class="mb-0 fw-medium text-success-600">12</h2>
                                        </div>
                                        <span
                                            class="px-16 py-4 rounded-pill bg-white border border-success-600 text-success-600 fw-medium">Completed</span>
                                    </div>
                                </div>
                                <!-- Progress Card End -->
                            </div>
                        </div>
                    </div>
                    <!-- Progress bar end -->
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <!-- Donut Chart Start -->
                    <div class="card h-100">
                        <div class="card-header border-bottom border-gray-100 flex-between gap-8 flex-wrap">
                            <h5 class="mb-0">Most Activity</h5>
                            <div class="dropdown flex-shrink-0">
                                <button class="text-gray-400 text-xl d-flex rounded-4" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ph-fill ph-dots-three-outline"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                    <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                        <div class="card-body p-12">
                                            <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                <ul>
                                                    <li class="mb-0">
                                                        <a href="students.html"
                                                            class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 w-100 rounded-8 fw-normal text-xs d-block text-start">
                                                            <span class="text"> <i class="ph ph-user me-4"></i>
                                                                View</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="flex-center mb-20">
                                <div id="activityDonutChart" class="w-auto d-inline-block"></div>
                            </div>

                            <div class="flex-between gap-8 flex-wrap mt-20">
                                <div class="flex-align flex-column">
                                    <span class="w-12 h-12 bg-white border border-3 border-main-600 rounded-circle"></span>
                                    <span class="text-13 my-4 text-main-600">Mentoring</span>
                                    <h6 class="mb-0">65.2%</h6>
                                </div>
                                <div class="flex-align flex-column">
                                    <span
                                        class="w-12 h-12 bg-white border border-3 border-main-two-600 rounded-circle"></span>
                                    <span class="text-13 my-4 text-main-two-600">Organization</span>
                                    <h6 class="mb-0">25.0%</h6>
                                </div>
                                <div class="flex-align flex-column">
                                    <span
                                        class="w-12 h-12 bg-white border border-3 border-danger-600 rounded-circle"></span>
                                    <span class="text-13 my-4 text-danger-600">Planning</span>
                                    <h6 class="mb-0">9.8%</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Donut Chart End -->
                </div>

            </div>
        </div>
    @endif
@endsection
