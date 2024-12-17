<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/11.2.0/css/shepherd.css"/>
<div class="report-widget">
    <style>
        .report-widget {
            --primary-color: #007bff;
            --primary-dark: #0056b3;
            --success-color: #28a745;
            font-family: "Cairo", sans-serif;
        }

        .report-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .report-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 123, 255, 0.3);
        }

        .chat-box {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 380px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px);
            visibility: hidden;
        }

        .chat-box.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .chat-header {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 15px 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h5 {
            margin: 0;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 5px;
        }

        .chat-body {
            padding: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            color: var(--primary-color);
            font-size: 24px;
        }

        .stat-card p {
            margin: 5px 0 0;
            color: #6c757d;
            font-size: 14px;
        }

        .chart-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            height: 200px;
        }

        .form-check {
            margin-bottom: 12px;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .form-check:hover {
            background-color: #f8f9fa;
        }

        .form-check label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .message-input {
            position: relative;
            margin-top: 15px;
        }

        .message-input textarea {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            resize: none;
            font-family: inherit;
        }

        .message-input i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #6c757d;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .btn-success {
            background: var(--success-color);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .tour-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: var(--success-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 999;
        }

        /* Tooltip Styles */
        .tooltip {
            position: absolute;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            max-width: 250px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .tooltip.active {
            opacity: 1;
            visibility: visible;
        }

        .tooltip-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
        }
    </style>

    <button id="reportBtn" class="report-btn">
        <i class="fas fa-comment-dots"></i>
    </button>



    <div id="chatBox" class="chat-box">
        <div class="chat-header">
            <h5><i class="fas fa-paper-plane"></i> إرسال تقرير</h5>
            <button class="close-btn" id="closeBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="chat-body">
            <div class="stats-grid" id="statsContainer">
                <div class="stat-card">
                    @php
                        $counts = App\Models\Report::all()->count();
                    @endphp
                    <h3>{{$counts}}</h3>
                    <p>إجمالي التقارير</p>
                </div>
                <div class="stat-card">
                    <h3>99.9%</h3>
                    <p>نسبة الحل</p>
                </div>
            </div>

            <div class="chart-container" id="chartContainer">
                <canvas id="reportsChart"></canvas>
            </div>

            <form id="reportForm" method="POST" action="{{route('report.save')}}">
                @csrf
                <div class="form-check">
                    <label>
                        <input type="checkbox" name="reason[]" value="cancelled" name="reason">
                        <i class="fas fa-calendar-xmark"></i>
                        إلغاء الجلسة
                    </label>
                </div>
                <div class="form-check">
                    <label>
                        <input type="checkbox" name="reason[]" value="payments" name="reason">
                        <i class="fas fa-money-bill-wave"></i>
                        المدفوعات
                    </label>
                </div>
                <div class="form-check">
                    <label>
                        <input type="checkbox" name="reason[]" value="instructor" name="reason">
                        <i class="fas fa-chalkboard-teacher"></i>
                        المعلم
                    </label>
                </div>

                <div class="message-input">
                    <i class="fas fa-message"></i>
                    <textarea rows="4" placeholder="اكتب رسالتك هنا..." name="message"></textarea>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i>
                        إرسال
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn">
                        <i class="fas fa-times"></i>
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/11.2.0/js/shepherd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.1/apexcharts.min.js"></script>
    <script>

        class ReportWidget {
            constructor() {
                this.chatBox = document.getElementById('chatBox');
                this.reportBtn = document.getElementById('reportBtn');
                this.closeBtn = document.getElementById('closeBtn');
                this.cancelBtn = document.getElementById('cancelBtn');
                this.tourBtn = document.getElementById('tourBtn');
                this.currentTourStep = 0;
                this.tourActive = false;

                this.init();
                this.initChart();
                this.setupEventListeners();
            }

            init() {
                // التأكد من تحميل المكتبات المطلوبة
                this.loadScript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js')
                    .then(() => this.initChart());
            }

            loadScript(src) {
                return new Promise((resolve, reject) => {
                    const script = document.createElement('script');
                    script.src = src;
                    script.onload = resolve;
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            }

            initChart() {
                if (typeof Chart === 'undefined') return;

                const ctx = document.getElementById('reportsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
                        datasets: [{
                            label: 'التقارير',
                            data: [30, 40, 35, 50, 49, 60, 70],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            setupEventListeners() {
                this.reportBtn.addEventListener('click', () => this.toggleChat());
                this.closeBtn.addEventListener('click', () => this.closeChat());
                this.cancelBtn.addEventListener('click', () => this.closeChat());
                this.tourBtn.addEventListener('click', () => this.startTour());
            }

            toggleChat() {
                this.chatBox.classList.toggle('active');
            }

            closeChat() {
                this.chatBox.classList.remove('active');
            }

            createTooltip(target, content, position = 'bottom') {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.innerHTML = content;

                const arrow = document.createElement('div');
                arrow.className = 'tooltip-arrow';
                tooltip.appendChild(arrow);

                document.body.appendChild(tooltip);

                const targetRect = target.getBoundingClientRect();
                const tooltipRect = tooltip.getBoundingClientRect();

                let top, left;

                switch (position) {
                    case 'top':
                        top = targetRect.top - tooltipRect.height - 10;
                        left = targetRect.left + (targetRect.width - tooltipRect.width) / 2;
                        arrow.style.borderWidth = '10px 10px 0 10px';
                        arrow.style.borderColor = 'white transparent transparent transparent';
                        arrow.style.bottom = '-10px';
                        arrow.style.left = '50%';
                        arrow.style.transform = 'translateX(-50%)';
                        break;
                    case 'bottom':
                        top = targetRect.bottom + 10;
                        left = targetRect.left + (targetRect.width - tooltipRect.width) / 2;
                        arrow.style.borderWidth = '0 10px 10px 10px';
                        arrow.style.borderColor = 'transparent transparent white transparent';
                        arrow.style.top = '-10px';
                        arrow.style.left = '50%';
                        arrow.style.transform = 'translateX(-50%)';
                        break;
                }

                tooltip.style.top = `${top}px`;
                tooltip.style.left = `${left}px`;
                tooltip.classList.add('active');

                return tooltip;
            }

            startTour() {
                this.tourActive = true;
                this.currentTourStep = 0;
                this.showTourStep();
            }

            showTourStep() {
                const steps = [{
                        target: '#reportBtn',
                        content: 'انقر هنا لفتح نموذج إنشاء تقرير جديد',
                        position: 'left'
                    },
                    {
                        target: '#statsContainer',
                        content: 'هنا يمكنك رؤية إحصائيات سريعة عن التقارير',
                        position: 'bottom'
                    },
                    {
                        target: '#chartContainer',
                        content: 'رسم بياني يوضح عدد التقارير خلال الأسبوع',
                        position: 'top'
                    }
                ];

                if (this.currentTourStep >= steps.length) {
                    this.endTour();
                    return;
                }

                const step = steps[this.currentTourStep];
                const target = document.querySelector(step.target);

                if (this.currentTooltip) {
                    this.currentTooltip.remove();
                }

                if (!this.chatBox.classList.contains('active') && this.currentTourStep > 0) {
                    this.toggleChat();
                }

                this.currentTooltip = this.createTooltip(target, `
                    <div style="margin-bottom: 10px">${step.content}</div>
                    <div style="text-align: left">
                        ${this.currentTourStep > 0 ?
                            '<button onclick="reportWidget.prevStep()" class="btn btn-secondary" style="padding: 5px 10px; margin-right: 5px">السابق</button>' :
                            ''}
                        <button onclick="reportWidget.nextStep()" class="btn btn-success" style="padding: 5px 10px">
                            ${this.currentTourStep === steps.length - 1 ? 'إنهاء' : 'التالي'}
                        </button>
                    </div>
                `, step.position);
            }

            nextStep() {
                this.currentTourStep++;
                this.showTourStep();
            }

            prevStep() {
                if (this.currentTourStep > 0) {
                    this.currentTourStep--;
                    this.showTourStep();
                }
            }

            endTour() {
                this.tourActive = false;
                if (this.currentTooltip) {
                    this.currentTooltip.remove();
                    this.currentTooltip = null;
                }
            }
        }

        // تهيئة الويدجت
        let reportWidget;
        document.addEventListener('DOMContentLoaded', () => {
            reportWidget = new ReportWidget();
            // جعل المتغير متاحًا عالميًا للوصول إليه من HTML
            window.reportWidget = reportWidget;
        });
    </script>
</div>
