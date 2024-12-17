@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script>
    <style>
        .file-explorer {
            background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
            padding: 30px;
            border-radius: 16px;
            direction: rtl;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .explorer-header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .explorer-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        .explorer-header button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        .explorer-header button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .file-card {
            background: white;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .file-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 30px rgba(37, 99, 235, 0.1);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .file-preview {
            background: #f8fafc;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px 12px 0 0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .file-preview::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(37, 99, 235, 0.05), rgba(37, 99, 235, 0));
            z-index: 1;
        }

        .file-info {
            padding: 15px;
            background: white;
            border-radius: 0 0 12px 12px;
        }

        .file-name {
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-meta {
            font-family: 'Cairo', sans-serif;
            font-size: 13px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .file-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            padding: 12px;
            display: flex;
            gap: 10px;
            justify-content: center;
            transform: translateY(100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .file-card:hover .file-actions {
            transform: translateY(0);
        }

        .file-actions button {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .file-actions .preview-btn {
            background: #2563eb;
            border: none;
            color: white;
        }

        .file-actions .preview-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .preview-container {
            background: white;
            border-radius: 16px;
            margin-top: 30px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .preview-title {
            font-family: 'Cairo', sans-serif;
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }

        .preview-content {
            min-height: 450px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .preview-content img,
        .preview-content video,
        .preview-content audio {
            max-width: 100%;
            max-height: 450px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .preview-content .document-preview {
            width: 100%;
            height: 650px;
            border: none;
            border-radius: 8px;
        }

        .btn-close-preview {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
        }

        .btn-close-preview:hover {
            background: #fee2e2;
            transform: rotate(90deg);
        }

        /* Animations for icons */
        .ph-duotone {
            transition: all 0.3s ease;
        }

        .file-card:hover .ph-duotone {
            transform: scale(1.1);
            filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.2));
        }

        /* Custom scrollbar */
        .file-explorer::-webkit-scrollbar {
            width: 8px;
        }

        .file-explorer::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .file-explorer::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        .file-explorer::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        .file-type-icon {
    font-size: 48px;
    color: #2563eb;
    transition: all 0.3s ease;
}

.file-type-doc { color: #2563eb; }
.file-type-sheet { color: #059669; }
.file-type-zip { color: #9333ea; }
.file-type-code { color: #0891b2; }

.file-preview .preview-icon {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.file-preview .preview-icon::after {
    content: attr(data-extension);
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
}

/* تحسين أنماط Shepherd */
.shepherd-content {
    border-radius: 12px !important;
    font-family: 'Cairo', sans-serif !important;
}

.shepherd-text {
    font-size: 16px !important;
    padding: 15px !important;
    color: #1e293b !important;
}

.shepherd-footer {
    padding: 10px 15px !important;
}

.shepherd-button {
    border-radius: 8px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 14px !important;
    padding: 8px 16px !important;
    transition: all 0.3s ease !important;
}

.shepherd-button-primary {
    background: #2563eb !important;
}

.shepherd-button-primary:hover {
    background: #1d4ed8 !important;
    transform: translateY(-2px);
}

/* تحسين أنماط SweetAlert2 */
.swal2-popup {
    font-family: 'Cairo', sans-serif !important;
    border-radius: 16px !important;
}

.swal2-title {
    font-size: 24px !important;
}

.swal2-html-container {
    font-size: 16px !important;
}

.swal2-confirm, .swal2-cancel {
    border-radius: 8px !important;
    padding: 8px 24px !important;
    font-size: 16px !important;
}
</style>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ph-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ph-x-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="file-explorer" id="fileExplorer">
    <!-- رأس الصفحة -->
    <div class="explorer-header d-flex justify-content-between align-items-center" id="explorerHeader">
        <h4 class="mb-0">مستكشف الملفات</h4>
        <div>
            <button class="btn btn-light btn-sm me-2" id="uploadBtn">
                <i class="ph-upload-simple"></i> رفع ملف
            </button>
            <button class="btn btn-light btn-sm" id="settingsBtn">
                <i class="ph-gear"></i> إعدادات
            </button>
        </div>
    </div>

    <!-- شبكة الملفات -->
    <div class="file-grid" id="fileGrid">
        @foreach($fileDetails as $file)
            <div class="file-card" data-file="{{ json_encode($file) }}">
                <div class="file-preview">
                    @php
                        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $fileType = strtolower($fileExtension);
                    @endphp

                    <div class="preview-icon" data-extension="{{ $fileExtension }}">
                        @switch($fileType)
                            @case('pdf')
                                <i class="ph-file-pdf ph-duotone file-type-icon"></i>
                                @break
                            @case('doc')
                            @case('docx')
                                <i class="ph-file-doc ph-duotone file-type-icon file-type-doc"></i>
                                @break
                            @case('xls')
                            @case('xlsx')
                                <i class="ph-file-xls ph-duotone file-type-icon file-type-sheet"></i>
                                @break
                            @case('zip')
                            @case('rar')
                                <i class="ph-file-zip ph-duotone file-type-icon file-type-zip"></i>
                                @break
                            @case('php')
                            @case('js')
                            @case('html')
                            @case('css')
                                <i class="ph-file-code ph-duotone file-type-icon file-type-code"></i>
                                @break
                            @case('jpg')
                            @case('jpeg')
                            @case('png')
                            @case('gif')
                                <i class="ph-image ph-duotone file-type-icon"></i>
                                @break
                            @case('mp4')
                            @case('avi')
                            @case('mov')
                                <i class="ph-video ph-duotone file-type-icon"></i>
                                @break
                            @case('mp3')
                            @case('wav')
                                <i class="ph-music-notes ph-duotone file-type-icon"></i>
                                @break
                            @default
                                <i class="ph-file-text ph-duotone file-type-icon"></i>
                        @endswitch
                    </div>
                </div>
                <div class="file-info">
                    <div class="file-name" title="{{ $file['name'] }}">{{ $file['name'] }}</div>
                    <div class="file-meta">
                        <span>{{ number_format($file['size'] / 1024, 2) }} كيلوبايت</span>
                        <span>•</span>
                        <span>{{ $fileExtension }}</span>
                    </div>
                </div>
                <div class="file-actions">
                    <button class="btn btn-primary btn-sm preview-btn" id="previewBtn">
                        <i class="ph-eye"></i> فتح
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn">
                        <i class="ph-trash"></i> حذف
                    </button>
                </div>
            </div>
        @endforeach
    </div>

        <!-- منطقة معاينة الملف -->
        <div id="preview-container" class="preview-container" style="display: none;">
            <div class="preview-header">
                <h5 class="preview-title mb-0"></h5>
                <button class="btn-close-preview">
                    <i class="ph-x-circle" style="font-size: 24px;"></i>
                </button>
            </div>
            <div class="preview-content"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة جولة التعريف
            const tour = new Shepherd.Tour({
                defaultStepOptions: {
                    classes: 'shadow-lg',
                    scrollTo: true,
                    cancelIcon: {
                        enabled: true
                    }
                },
                useModalOverlay: true
            });

            // إضافة خطوات الجولة
            tour.addStep({
                id: 'welcome',
                text: 'مرحباً بك في مستكشف الملفات! دعنا نأخذ جولة سريعة.',
                attachTo: {
                    element: '#fileExplorer',
                    on: 'bottom'
                },
                buttons: [
                    {
                        text: 'تخطي الجولة',
                        action: tour.complete,
                        classes: 'shepherd-button-secondary'
                    },
                    {
                        text: 'التالي',
                        action: tour.next
                    }
                ]
            });

            tour.addStep({
                id: 'upload',
                text: 'يمكنك رفع الملفات الجديدة من هنا',
                attachTo: {
                    element: '#uploadBtn',
                    on: 'bottom'
                },
                buttons: [
                    {
                        text: 'السابق',
                        action: tour.back
                    },
                    {
                        text: 'التالي',
                        action: tour.next
                    }
                ]
            });

            tour.addStep({
                id: 'files',
                text: 'هنا تظهر جميع ملفاتك. يمكنك فتحها أو حذفها بسهولة.',
                attachTo: {
                    element: '#fileGrid',
                    on: 'top'
                },
                buttons: [
                    {
                        text: 'السابق',
                        action: tour.back
                    },
                    {
                        text: 'إنهاء الجولة',
                        action: tour.complete
                    }
                ]
            });

            // بدء الجولة عند أول زيارة
            if (!localStorage.getItem('tourComplete')) {
                tour.start();
                localStorage.setItem('tourComplete', 'true');
            }

            // تعامل مع حذف الملفات
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const fileCard = btn.closest('.file-card');
                    const fileData = JSON.parse(fileCard.dataset.file);

                    const result = await Swal.fire({
                        title: 'تأكيد الحذف',
                        text: `هل أنت متأكد من حذف الملف "${fileData.name}"؟`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'نعم، احذف',
                        cancelButtonText: 'إلغاء',
                        customClass: {
                            popup: 'swal-rtl'
                        }
                    });

                    if (result.isConfirmed) {
                        // إرسال طلب الحذف
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("file.delete") }}';

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';

                        const fileInput = document.createElement('input');
                        fileInput.type = 'hidden';
                        fileInput.name = 'file';
                        fileInput.value = fileData.path;

                        form.appendChild(csrfToken);
                        form.appendChild(fileInput);
                        document.body.appendChild(form);

                        try {
                            form.submit();
                        } catch (error) {
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ أثناء حذف الملف',
                                icon: 'error',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    }
                });
            });

            // معاينة الملفات (الكود السابق)
            const previewContainer = document.getElementById('preview-container');
            const previewContent = previewContainer.querySelector('.preview-content');
            const previewTitle = previewContainer.querySelector('.preview-title');
            const closePreviewBtn = previewContainer.querySelector('.btn-close-preview');

            function openFilePreview(file) {
                const fileData = JSON.parse(file.dataset.file);
                const fileExtension = fileData.name.split('.').pop().toLowerCase();

                previewTitle.textContent = fileData.name;
                previewContent.innerHTML = '<div class="animate-pulse flex justify-center items-center"><div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div></div>';

                setTimeout(() => {
                    switch (fileExtension) {
                        case 'pdf':
                            const pdfFrame = document.createElement('iframe');
                            pdfFrame.src = fileData.url;
                            pdfFrame.className = 'document-preview';
                            previewContent.innerHTML = '';
                            previewContent.appendChild(pdfFrame);
                            break;

                        case 'doc':
                        case 'docx':
                        case 'xls':
                        case 'xlsx':
                            previewContent.innerHTML = `
                                <div class="text-center p-8">
                                    <i class="ph-file-doc ph-duotone" style="font-size: 64px; color: #2563eb;"></i>
                                    <p class="mt-4 text-gray-600 text-lg">يمكنك تحميل المستند لعرضه</p>
                                    <a href="${fileData.url}" class="btn btn-primary mt-3" download>
                                        <i class="ph-download"></i> تحميل الملف
                                    </a>
                                </div>
                            `;
                            break;

                        case 'zip':
                        case 'rar':
                            previewContent.innerHTML = `
                                <div class="text-center p-8">
                                    <i class="ph-file-zip ph-duotone" style="font-size: 64px; color: #9333ea;"></i>
                                    <p class="mt-4 text-gray-600 text-lg">اضغط هنا لتحميل الملف المضغوط</p>
                                    <a href="${fileData.url}" class="btn btn-primary mt-3" download>
                                        <i class="ph-download"></i> تحميل الملف
                                    </a>
                                </div>
                            `;
                            break;

                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':
                            const img = document.createElement('img');
                            img.src = fileData.url;
                            img.alt = fileData.name;
                            img.onload = () => {
                                previewContent.innerHTML = '';
                                previewContent.appendChild(img);
                                img.style.opacity = '0';
                                setTimeout(() => img.style.opacity = '1', 50);
                            };
                    break;

                case 'mp4':
                case 'webm':
                case 'avi':
                    const video = document.createElement('video');
                    video.src = fileData.url;
                    video.controls = true;
                    video.className = 'w-full max-h-[450px] rounded-lg';
                    previewContent.innerHTML = '';
                    previewContent.appendChild(video);
                    break;

                case 'mp3':
                case 'wav':
                    const audioContainer = document.createElement('div');
                    audioContainer.className = 'text-center p-8';
                    audioContainer.innerHTML = `
                        <i class="ph-music-notes ph-duotone mb-4" style="font-size: 64px; color: #2563eb;"></i>
                        <audio controls class="w-full">
                            <source src="${fileData.url}" type="audio/${fileExtension}">
                            متصفحك لا يدعم تشغيل الملفات الصوتية.
                        </audio>
                    `;
                    previewContent.innerHTML = '';
                    previewContent.appendChild(audioContainer);
                    break;

                case 'php':
                case 'js':
                case 'html':
                case 'css':
                case 'txt':
                    fetch(fileData.url)
                        .then(response => response.text())
                        .then(code => {
                            previewContent.innerHTML = `
                                <div class="w-full h-full bg-gray-900 rounded-lg p-4 overflow-auto">
                                    <pre class="text-white font-mono text-sm"><code>${escapeHtml(code)}</code></pre>
                                </div>
                            `;
                        })
                        .catch(() => {
                            showErrorPreview('حدث خطأ أثناء تحميل الملف');
                        });
                    break;

                default:
                    showErrorPreview('لا يمكن معاينة هذا النوع من الملفات');
            }
        }, 800);

        previewContainer.style.display = 'block';
        previewContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // دوال مساعدة
    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function showErrorPreview(message) {
        previewContent.innerHTML = `
            <div class="text-center p-8">
                <i class="ph-warning-circle ph-duotone" style="font-size: 64px; color: #ef4444;"></i>
                <p class="mt-4 text-gray-600 text-lg">${message}</p>
            </div>
        `;
    }

    // تحسين تجربة رفع الملفات
    const uploadBtn = document.getElementById('uploadBtn');
    uploadBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'رفع ملف جديد',
            html: `
                <div class="upload-area p-4 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="file" id="fileInput" class="hidden" multiple>
                    <div class="text-center">
                        <i class="ph-upload-simple" style="font-size: 48px; color: #2563eb;"></i>
                        <p class="mt-2">اسحب الملفات هنا أو اضغط للاختيار</p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'رفع',
            cancelButtonText: 'إلغاء',
            customClass: {
                popup: 'swal-rtl'
            },
            preConfirm: () => {
                const fileInput = document.getElementById('fileInput');
                return fileInput.files;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value.length > 0) {
                const formData = new FormData();
                for(let file of result.value) {
                    formData.append('files[]', file);
                }

                // إظهار شريط التقدم
                Swal.fire({
                    title: 'جاري الرفع...',
                    html: '<div class="progress-bar"></div>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // إرسال الملفات للخادم
                fetch('/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الرفع بنجاح',
                            text: 'سيتم تحديث الصفحة لعرض الملفات الجديدة',
                            confirmButtonText: 'حسناً'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: error.message || 'حدث خطأ أثناء رفع الملفات',
                        confirmButtonText: 'حسناً'
                    });
                });
            }
        });
    });

    // تهيئة منطقة السحب والإفلات
    const fileExplorer = document.getElementById('fileExplorer');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileExplorer.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        fileExplorer.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileExplorer.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        fileExplorer.classList.add('drag-active');
    }

    function unhighlight() {
        fileExplorer.classList.remove('drag-active');
    }

    fileExplorer.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if(files.length > 0) {
            uploadFiles(files);
        }
    }

    function uploadFiles(files) {
        // نفس منطق رفع الملفات السابق
        const formData = new FormData();
        for(let file of files) {
            formData.append('files[]', file);
        }

        // إظهار شريط التقدم
        Swal.fire({
            title: 'جاري الرفع...',
            html: '<div class="progress-bar"></div>',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // إرسال الملفات
        fetch('/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الرفع بنجاح',
                    text: 'سيتم تحديث الصفحة لعرض الملفات الجديدة',
                    confirmButtonText: 'حسناً'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: error.message || 'حدث خطأ أثناء رفع الملفات',
                confirmButtonText: 'حسناً'
            });
        });
    }

    // Event listeners
    document.querySelectorAll('.preview-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const fileCard = btn.closest('.file-card');
            openFilePreview(fileCard);
        });
    });

    document.querySelectorAll('.file-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.file-actions')) {
                openFilePreview(this);
            }
        });
    });

    closePreviewBtn.addEventListener('click', () => {
        previewContainer.style.display = 'none';
    });
});
</script>

@endsection
