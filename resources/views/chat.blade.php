@extends('layouts.dashboard')

@section('content')
<style>
    .list-group-item {
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(-5px);
    }

    #messages-container {
        background-color: #f8f9fa;
        scrollbar-width: thin;
        scrollbar-color: #6c757d #e9ecef;
    }

    #messages-container::-webkit-scrollbar {
        width: 8px;
    }

    #messages-container::-webkit-scrollbar-track {
        background: #e9ecef;
    }

    #messages-container::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        border-radius: 4px;
    }
</style>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Users List -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people-fill me-2"></i>اختر مستخدمًا أو مجموعة
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="user-list" class="list-group list-group-flush">
                        <!-- Users will be dynamically added here -->
                    </div>
                    <hr>
                    <h6 class="text-center text-secondary">المجموعات</h6>
                    <div id="group-list" class="list-group list-group-flush">
                        <!-- Groups will be dynamically added here -->
                    </div>
                </div>
                <button id="create-group-btn" class="btn btn-primary m-3">
                    <i class="bi bi-people-fill me-2"></i> إنشاء مجموعة
                </button>
                <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createGroupModalLabel">إنشاء مجموعة جديدة</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="create-group-form">
                                    <div class="mb-3">
                                        <label for="group-name" class="form-label">اسم المجموعة</label>
                                        <input type="text" id="group-name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="group-users" class="form-label">اختر الأعضاء</label>
                                        <select id="group-users" class="form-select" multiple required>
                                            <!-- ستملأ لاحقًا بقائمة المستخدمين -->
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">إنشاء</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Chat Container -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-chat-dots-fill me-2"></i>
                        <span id="selected-user-name">اختر مستخدمًا أو مجموعة لبدء المحادثة</span>
                    </h5>
                </div>
                <div id="messages-container" class="card-body overflow-auto" style="height: 400px;">
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-chat-text display-4 mb-3"></i>
                        <p>اختر محادثة لعرض الرسائل</p>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="message-form" class="d-flex">
                        <!-- زر فتح المودال -->
                        <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#fileModal">
                            <i class="bi bi-paperclip"></i> أضف ملف
                        </button>

                        <!-- حقل الإدخال للرسائل -->
                        <input type="text" id="message-input" class="form-control me-2" placeholder="اكتب رسالتك..." required>

                        <!-- زر الإرسال -->
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
<!-- مودال اختيار الملف -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">إضافة ملف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="file-form">
                    <div class="mb-3">
                        <label for="file-input" class="form-label">اختر ملفًا</label>
                        <input type="file" id="file-input" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="file-type" class="form-label">نوع الملف</label>
                        <select id="file-type" class="form-select">
                            <option value="homework">واجب</option>
                            <option value="explanation">شرح</option>
                            <option value="exam">امتحان</option>
                            <option value="video">فيديو</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="add-file-btn">إضافة</button>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-file-btn').addEventListener('click', function () {
    const fileInput = document.getElementById('file-input');
    const fileType = document.getElementById('file-type').value;

    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        alert(`تم اختيار الملف: ${fileName} (نوع: ${fileType})`);
    } else {
        alert('يرجى اختيار ملف أولاً.');
    }

    // إغلاق المودال
    const fileModal = new bootstrap.Modal(document.getElementById('fileModal'));
    fileModal.hide();
});

    const routes = {
        getUsers: "{{ route('usersss.index') }}",
        getGroups: "{{ route('groups.index') }}",
        createConversation: "{{ route('conversations.create') }}",
        sendMessage: "{{ route('messages.store') }}",
        getMessages: (conversationId) => "{{ route('messages.show', ':id') }}".replace(':id', conversationId),
    };

    let selectedConversationId = null;
    const loadUsersForModal = async () => {
    try {
        const response = await fetch(routes.getUsers);
        const users = await response.json();

        const userSelect = document.getElementById('group-users');
        userSelect.innerHTML = '';

        users.forEach((user) => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            userSelect.appendChild(option);
        });
    } catch (error) {
        console.error('خطأ أثناء تحميل المستخدمين:', error);
    }
};


document.getElementById('create-group-btn').addEventListener('click', () => {
    loadUsersForModal();
    const modal = new bootstrap.Modal(document.getElementById('createGroupModal'));
    modal.show();
});



document.getElementById('create-group-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const groupName = document.getElementById('group-name').value.trim(); // تأكد من إزالة الفراغات
    if (!groupName) {
        alert('يرجى إدخال اسم المجموعة.');
        return;
    }

    const selectedUsers = Array.from(document.getElementById('group-users').selectedOptions).map(option => option.value);

    try {
        const response = await fetch(routes.createConversation, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name: groupName, // تأكد من إرسال الاسم هنا
                user_ids: [{{ auth()->id() }}, ...selectedUsers],
            }),
        });

        if (response.ok) {
            alert('تم إنشاء المجموعة بنجاح!');
            document.getElementById('create-group-form').reset(); // إعادة تعيين النموذج
        } else {
            console.error('خطأ أثناء إنشاء المجموعة:', await response.text());
        }
    } catch (error) {
        console.error('خطأ أثناء إنشاء المجموعة:', error);
    }
});


    // تحميل المستخدمين والمجموعات
    const loadUsersAndGroups = async () => {
        try {
            // تحميل المستخدمين
            const usersResponse = await fetch(routes.getUsers);
            const users = await usersResponse.json();

            const userList = document.getElementById('user-list');
            userList.innerHTML = '';
            users.forEach((user) => {
                const userButton = document.createElement('button');
                userButton.textContent = user.name;
                userButton.classList.add('list-group-item', 'list-group-item-action');
                userButton.onclick = () => startConversation(user.id, user.name, 'user');
                userList.appendChild(userButton);
            });

            // تحميل المجموعات
            const groupsResponse = await fetch(routes.getGroups);
            const groups = await groupsResponse.json();

            const groupList = document.getElementById('group-list');
            groupList.innerHTML = '';
            groups.forEach((group) => {
                const groupButton = document.createElement('button');
                groupButton.textContent = group.name;
                groupButton.classList.add('list-group-item', 'list-group-item-action');
                groupButton.onclick = () => startConversation(group.id, group.name, 'group');
                groupList.appendChild(groupButton);
            });
        } catch (error) {
            console.error('خطأ أثناء تحميل البيانات:', error);
        }
    };

    // بدء محادثة
    const startConversation = async (id, name, type) => {
        selectedConversationId = id;
        document.getElementById('selected-user-name').textContent = `محادثة مع: ${name}`;
        loadMessages(id, type);
    };


    const loadGroups = async () => {
    try {
        const response = await fetch("{{ route('groups.index') }}");
        const groups = await response.json();

        const groupList = document.getElementById('user-list');
        groupList.innerHTML = ''; // تفريغ القائمة

        groups.forEach((group) => {
            const groupButton = document.createElement('button');
            groupButton.textContent = group.name; // عرض اسم المجموعة
            groupButton.classList.add('list-group-item', 'list-group-item-action');
            groupButton.onclick = () => startConversation(group.id, group.name);
            groupList.appendChild(groupButton);
        });
    } catch (error) {
        console.error('خطأ أثناء تحميل المجموعات:', error);
    }
};

    // تحميل الرسائل
    const loadMessages = async (id, type) => {
        try {
            const response = await fetch(routes.getMessages(id));
            const messages = await response.json();

            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = '';

            messages.forEach((msg) => {
                const messageElement = document.createElement('div');
                messageElement.innerHTML = `<strong>${msg.user.name}:</strong> ${msg.content}`;
                messageElement.classList.add('p-2', 'border-bottom');
                messagesContainer.appendChild(messageElement);
            });

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        } catch (error) {
            console.error('خطأ أثناء تحميل الرسائل:', error);
        }
    };

    document.addEventListener('DOMContentLoaded', loadUsersAndGroups);


</script>
@endsection
