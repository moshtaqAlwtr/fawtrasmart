@extends('master')

@section('title')
    أدارة المهام
@stop

@section('content')
<div class="fs-5">
    <div class="fs-5">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> أدارة المهام</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                                <li class="breadcrumb-item active">عرض</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- إضافة مكتبة Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
            background: #f0f2f5;
            margin: 0;
        }
        .header {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
        }
        .list-card {
            background: linear-gradient(135deg, #9b46f7, #2575fc);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            color: white;
        }
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .menu-btn {
            cursor: pointer;
            background: none;
            border: none;
            font-size: 18px;
            color: white;
            position: relative;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
            z-index: 1;
            right: 0;
            top: 20px;
            min-width: 160px;
        }
        .dropdown-content button {
            width: 100%;
            padding: 10px;
            text-align: right;
            border: none;
            background: none;
            cursor: pointer;
            color: black;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }
        .dropdown-content button i {
            font-size: 16px;
        }
        .card {
            background: white;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            color: black;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .card-details {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }
        .card-details i {
            color: #6a11cb;
        }
        .task-count {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        .tasks {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .task {
            display: flex;
            align-items: center;
            margin-top: 10px;
            width: 100%;
            cursor: pointer;
        }
        .task-done {
            color: green;
            background: #e0f7e9;
        }
        .task-checkbox {
            margin-left: 5px;
        }
        .add-card-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 10px;
        }
        .add-card-btn::before {
            content: '+';
            font-size: 20px;
            margin-left: 5px;
        }
        .card-input-container {
            display: none;
            margin-top: 10px;
        }
        .card-input-container input,
        .card-input-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .card-input-container button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
        .confirm-add-card {
            background: #4CAF50;
            color: white;
        }
        .cancel-add-card {
            background: #f44336;
            color: white;
        }
        .add-task {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .add-task::before {
            content: '+';
            font-size: 20px;
            margin-left: 5px;
        }
        .task-input-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .task-input-container input {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .list-input-container {
            display: none;
            margin-top: 10px;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .list-input-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .list-input-container button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
        .add-list-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-list-btn {
            background: #f44336;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .assigned-member {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .assigned-member img {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        #invite-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>

    <div class="header">
        إدارة المهام
    </div>
    <button id="show-list-input" class="add-list-btn">+ إضافة قائمة</button>
    <button id="invite-member-btn" class="add-list-btn">+ دعوة عضو</button>
    <div class="list-input-container" id="list-input-container">
        <input type="text" id="list-title" placeholder="عنوان القائمة">
        <button id="add-list" class="add-list-btn">إضافة</button>
        <button id="cancel-list" class="cancel-list-btn">إلغاء</button>
    </div>
    <div id="invite-modal">
        <input type="text" id="invite-email" placeholder="أدخل البريد الإلكتروني أو اسم المستخدم">
        <button id="send-invite" class="add-list-btn">إرسال الدعوة</button>
        <button id="cancel-invite" class="cancel-list-btn">إلغاء</button>
    </div>
    <div class="board" id="board"></div>
    
    <script>
        document.getElementById('show-list-input').addEventListener('click', function() {
            document.getElementById('list-input-container').style.display = 'block';
        });

        document.getElementById('cancel-list').addEventListener('click', function() {
            document.getElementById('list-input-container').style.display = 'none';
        });

        document.getElementById('add-list').addEventListener('click', function() {
            const listTitle = document.getElementById('list-title').value.trim();
            if (!listTitle) return;
            
            const list = document.createElement('div');
            list.className = 'list-card';
            list.innerHTML = `
                <div class="list-header">
                    <span>${listTitle}</span>
                    <button class="menu-btn">⋮</button>
                    <div class="dropdown-content">
                        <button class="edit-btn"><i class="fas fa-edit" style="color: #4CAF50;"></i> تعديل</button>
                        <button class="delete-btn"><i class="fas fa-trash-alt" style="color: #f44336;"></i> حذف</button>
                        <button class="toggle-btn"><i class="fas fa-power-off" style="color: #FF9800;"></i> تعطيل/تنشيط</button>
                        <button class="assign-btn"><i class="fas fa-user-plus" style="color: #2196F3;"></i> إسناد عضو</button>
                        <button class="unassign-btn"><i class="fas fa-user-minus" style="color: #9C27B0;"></i> إلغاء إسناد</button>
                    </div>
                </div>
                <div class="cards"></div>
                <button class="add-card-btn"></button>
                <div class="card-input-container" style="display: none;">
                    <input type="text" class="card-title" placeholder="عنوان البطاقة">
                    <input type="date" class="start-date" placeholder="من">
                    <input type="date" class="end-date" placeholder="إلى">
                <select class="assigned-member-select">
    <option value="">اختر الموظف المكلف</option>
    @foreach($employees as $employee)
        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
    @endforeach
</select>

                    <button class="confirm-add-card">إضافة</button>
                    <button class="cancel-add-card">إلغاء</button>
                </div>
            `;
            document.getElementById('board').appendChild(list);
            document.getElementById('list-input-container').style.display = 'none';
            document.getElementById('list-title').value = '';
            
            const addCardBtn = list.querySelector('.add-card-btn');
            const cardInputContainer = list.querySelector('.card-input-container');
            const confirmAddCard = list.querySelector('.confirm-add-card');
            const cancelAddCard = list.querySelector('.cancel-add-card');
            const cardsContainer = list.querySelector('.cards');
            
            addCardBtn.addEventListener('click', function() {
                cardInputContainer.style.display = 'block';
                addCardBtn.style.display = 'none';
            });
            
            cancelAddCard.addEventListener('click', function() {
                cardInputContainer.style.display = 'none';
                addCardBtn.style.display = 'block';
            });
            
            confirmAddCard.addEventListener('click', function() {
                const cardTitle = list.querySelector('.card-title').value.trim();
                const startDate = list.querySelector('.start-date').value;
                const endDate = list.querySelector('.end-date').value;
                const assignedMember = list.querySelector('.assigned-member-select').value;
                if (!cardTitle || !startDate || !endDate || !assignedMember) return;
                
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-header">
                        <div class="card-title">${cardTitle}</div>
                        <div class="assigned-member">
                            <img src="https://via.placeholder.com/20" alt="صورة العضو">
                            <span>${assignedMember}</span>
                        </div>
                    </div>
                    <div class="card-details">
                        <i class="fas fa-calendar-alt"></i>
                        <span>من: ${startDate}</span>
                        <i class="fas fa-arrow-right"></i>
                        <span>إلى: ${endDate}</span>
                    </div>
                    <div class="task-count">عدد المهام: <span>0</span></div>
                    <div class="tasks"></div>
                    <div class="task-input-container">
                        <input type="text" class="task-title" placeholder="إضافة مهمة">
                        <button class="add-task"></button>
                    </div>
                `;
                
                cardsContainer.appendChild(card);
                list.querySelector('.card-title').value = '';
                list.querySelector('.start-date').value = '';
                list.querySelector('.end-date').value = '';
                list.querySelector('.assigned-member-select').value = '';
                cardInputContainer.style.display = 'none';
                addCardBtn.style.display = 'block';
                
                const addTaskBtn = card.querySelector('.add-task');
                const tasksContainer = card.querySelector('.tasks');
                const taskInput = card.querySelector('.task-title');
                const taskCount = card.querySelector('.task-count span');
                
                addTaskBtn.addEventListener('click', function() {
                    const taskText = taskInput.value.trim();
                    if (!taskText) return;
                    
                    const task = document.createElement('div');
                    task.className = 'task';
                    task.innerHTML = `
                        <input type="checkbox" class="task-checkbox">
                        <span>${taskText}</span>
                    `;
                    
                    tasksContainer.appendChild(task);
                    taskInput.value = '';
                    
                    // تحديث العداد
                    const currentCount = parseInt(taskCount.textContent);
                    taskCount.textContent = currentCount + 1;
                    
                    task.querySelector('.task-checkbox').addEventListener('change', function() {
                        if (this.checked) {
                            task.classList.add('task-done');
                        } else {
                            task.classList.remove('task-done');
                        }
                    });
                });
            });

            // إظهار/إخفاء القائمة المنسدلة
            const menuBtn = list.querySelector('.menu-btn');
            const dropdownContent = list.querySelector('.dropdown-content');
            menuBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
            });

            // إغلاق القائمة المنسدلة عند النقر خارجها
            document.addEventListener('click', function() {
                dropdownContent.style.display = 'none';
            });

            // إضافة وظائف القائمة المنسدلة
            const editBtn = list.querySelector('.edit-btn');
            const deleteBtn = list.querySelector('.delete-btn');
            const toggleBtn = list.querySelector('.toggle-btn');
            const assignBtn = list.querySelector('.assign-btn');
            const unassignBtn = list.querySelector('.unassign-btn');

            editBtn.addEventListener('click', function() {
                alert('تم النقر على تعديل');
            });

            deleteBtn.addEventListener('click', function() {
                list.remove();
            });

            toggleBtn.addEventListener('click', function() {
                list.style.opacity = list.style.opacity === '0.5' ? '1' : '0.5';
            });

            assignBtn.addEventListener('click', function() {
                const selectedTask = list.querySelector('.task:hover');
                if (selectedTask) {
                    const assignedMemberDiv = selectedTask.querySelector('.assigned-member');
                    assignedMemberDiv.innerHTML = `
                        <span>عضو1</span>
                        <img src="https://via.placeholder.com/20" alt="صورة العضو">
                    `;
                }
            });

            unassignBtn.addEventListener('click', function() {
                const selectedTask = list.querySelector('.task:hover');
                if (selectedTask) {
                    const assignedMemberDiv = selectedTask.querySelector('.assigned-member');
                    assignedMemberDiv.innerHTML = '';
                }
            });
        });

        // دعوة عضو
        document.getElementById('invite-member-btn').addEventListener('click', function() {
            document.getElementById('invite-modal').style.display = 'block';
        });

        document.getElementById('cancel-invite').addEventListener('click', function() {
            document.getElementById('invite-modal').style.display = 'none';
        });

        document.getElementById('send-invite').addEventListener('click', function() {
            const inviteEmail = document.getElementById('invite-email').value.trim();
            if (!inviteEmail) return;

            console.log(`تم إرسال دعوة إلى: ${inviteEmail}`);
            document.getElementById('invite-modal').style.display = 'none';
            document.getElementById('invite-email').value = '';
        });
    </script>
@endsection