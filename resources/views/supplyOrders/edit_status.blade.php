@extends('master')

@section('title')
    تعديل قائمة الحالات - أمر التوريد
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل قائمة الحالات - أمر التوريد</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <a href="" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>اللون</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="statusTable">
                                <tr data-status-id="1">
                                    <td>
                                        <input type="text" class="form-control form-control-lg" placeholder="اسم الحالة" value="حالة 1" />
                                    </td>
                                    <td>
                                        <div class="custom-dropdown">
                                            <div class="dropdown-toggle" style="background-color: #009688;"></div>
                                            <div class="dropdown-menu">
                                                <div class="color-options">
                                                    <div class="color-option" style="background-color: #009688;" data-value="#009688"></div>
                                                    <div class="color-option" style="background-color: #4CAF50;" data-value="#4CAF50"></div>
                                                    <div class="color-option" style="background-color: #F44336;" data-value="#F44336"></div>
                                                    <div class="color-option" style="background-color: #FF9800;" data-value="#FF98000"></div>
                                                    <div class="color-option" style="background-color: #2196F3;" data-value="#2196F3"></div>
                                                    <div class="color-option" style="background-color: #9C27B0;" data-value="#9C27B0"></div>
                                                    <div class="color-option" style="background-color: #673AB7;" data-value="#673AB7"></div>
                                                    <div class="color-option" style="background-color: #3F51B5;" data-value="#3F51B5"></div>
                                                    <div class="color-option" style="background-color: #00BCD4;" data-value="#00BCD4"></div>
                                                    <div class="color-option" style="background-color: #8BC34A;" data-value="#8BC34A"></div>
                                                    <div class="color-option" style="background-color: #CDDC39;" data-value="#CDDC39"></div>
                                                    <div class="color-option" style="background-color: #FFEB3B;" data-value="#FFEB3B"></div>
                                                    <div class="color-option" style="background-color: #FFC107;" data-value="#FFC107"></div>
                                                    <div class="color-option" style="background-color: #FF9800;" data-value="#FF9800"></div>
                                                    <div class="color-option" style="background-color: #FF5722;" data-value="#FF5722"></div>
                                                    <div class="color-option" style="background-color: #795548;" data-value="#795548"></div>
                                                    <div class="color-option" style="background-color: #9E9E9E;" data-value="#9E9E9E"></div>
                                                    <div class="color-option" style="background-color: #607D8B;" data-value="#607D8B"></div>
                                                    <div class="color-option" style="background-color: #000000;" data-value="#000000"></div>
                                                    <div class="color-option" style="background-color: #FFFFFF;" data-value="#FFFFFF"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-control">
                                            <option value="open">مفتوح</option>
                                            <option value="closed">مغلق</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn">
                                            <i class="feather icon-edit"></i> تعديل
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-btn">
                                            <i class="feather icon-trash"></i> حذف
                                        </button>
                                    </td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-success mt-2" id="addNewStatus">
                        <i class="feather icon-plus"></i> إضافة حالة جديدة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">تعديل الحالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editStatusForm">
                        <div class="form-group">
                            <label for="editStatusName">اسم الحالة</label>
                            <input type="text" class="form-control" id="editStatusName" placeholder="اسم الحالة">
                        </div>
                        <div class="form-group">
                            <label for="editStatusColor">اللون</label>
                            <div class="custom-dropdown">
                                <div class="dropdown-toggle" id="editColorDisplay" style="background-color: #009688;"></div>
                                <div class="dropdown-menu">
                                    <div class="color-options">
                                        <!-- Include color options here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editStatusState">الحالة</label>
                            <select class="form-control" id="editStatusState">
                                <option value="open">مفتوح</option>
                                <option value="closed">مغلق</option>
                            </select>
                        </div>
                        <input type="hidden" id="editStatusId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary" id="saveEditStatus">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle dropdown visibility
        document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const menu = this.nextElementSibling;
                menu.classList.toggle('show');
            });
        });

        // Handle color selection
        function setupDropdowns() {
            document.querySelectorAll('.color-option').forEach(function(option) {
                option.addEventListener('click', function() {
                    const selectedColor = this.getAttribute('data-value');
                    const display = this.closest('.custom-dropdown').querySelector('.dropdown-toggle');
                    display.style.backgroundColor = selectedColor;
                    this.closest('.dropdown-menu').classList.remove('show'); // Hide options after selection
                });
            });
        }

        // Adding new status row
        document.getElementById('addNewStatus').addEventListener('click', function() {
            let newRow = `
                <tr>
                    <td>
                        <input type="text" class="form-control form-control-lg" placeholder="اسم الحالة" />
                    </td>
                    <td>
                        <div class="custom-dropdown">
                            <div class="dropdown-toggle" style="background-color: #009688;"></div>
                            <div class="dropdown-menu">
                                <div class="color-options">
                                    <div class="color-option" style="background-color: #009688;" data-value="#009688"></div>
                                    <div class="color-option" style="background-color: #4CAF50;" data-value="#4CAF50"></div>
                                    <div class="color-option" style="background-color: #F44336;" data-value="#F44336"></div>
                                    <div class="color-option" style="background-color: #FF9800;" data-value="#FF98000"></div>
                                    <div class="color-option" style="background-color: #2196F3;" data-value="#2196F3"></div>
                                    <div class="color-option" style="background-color: #9C27B0;" data-value="#9C27B0"></div>
                                    <div class="color-option" style="background-color: #673AB7;" data-value="#673AB7"></div>
                                    <div class="color-option" style="background-color: #3F51B5;" data-value="#3F51B5"></div>
                                    <div class="color-option" style="background-color: #00BCD4;" data-value="#00BCD4"></div>
                                    <div class="color-option" style="background-color: #8BC34A;" data-value="#8BC34A"></div>
                                    <div class="color-option" style="background-color: #CDDC39;" data-value="#CDDC39"></div>
                                    <div class="color-option" style="background-color: #FFEB3B;" data-value="#FFEB3B"></div>
                                    <div class="color-option" style="background-color: #FFC107;" data-value="#FFC107"></div>
                                    <div class="color-option" style="background-color: #FF9800;" data-value="#FF9800"></div>
                                    <div class="color-option" style="background-color: #FF5722;" data-value="#FF5722"></div>
                                    <div class="color-option" style="background-color: #795548;" data-value="#795548"></div>
                                    <div class="color-option" style="background-color: #9E9E9E;" data-value="#9E9E9E"></div>
                                    <div class="color-option" style="background-color: #607D8B;" data-value="#607D8B"></div>
                                    <div class="color-option" style="background-color: #000000;" data-value="#000000"></div>
                                    <div class="color-option" style="background-color: #FFFFFF;" data-value="#FFFFFF"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <select class="form-control">
                            <option value="open">مفتوح</option>
                            <option value="closed">مغلق</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-btn">
                            <i class="feather icon-trash"></i> حذف
                        </button>
                    </td>
                </tr>
            `;
            document.getElementById('statusTable').insertAdjacentHTML('beforeend', newRow);
            setupDropdowns(); // Reinitialize dropdowns for new row
        });

        // Edit Status
        document.addEventListener('click', function(e) {
            if (e.target && e.target.matches('.edit-btn')) {
                const row = e.target.closest('tr');
                const statusName = row.querySelector('input[type="text"]').value;
                const colorDisplay = row.querySelector('.dropdown-toggle').style.backgroundColor;
                const statusState = row.querySelector('select').value;

                // Populate the modal fields
                document.getElementById('editStatusName').value = statusName;
                document.getElementById('editColorDisplay').style.backgroundColor = colorDisplay;
                document.getElementById('editStatusState').value = statusState;

                // Store the status ID (if applicable)
                document.getElementById('editStatusId').value = row.getAttribute('data-status-id'); // Assuming you set this attribute

                // Show the modal
                $('#editStatusModal').modal('show');
            }
        });

        // Save edited status
        document.getElementById('saveEditStatus').addEventListener('click', function() {
            const statusId = document.getElementById('editStatusId').value;
            const updatedData = {
                name: document.getElementById('editStatusName').value,
                color: document.getElementById('editColorDisplay').style.backgroundColor,
                state: document.getElementById('editStatusState').value,
            };

            // Send AJAX request to update the status
            fetch(`/statuses/${statusId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(updatedData),
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response
                if (data.success) {
                    // Update the row in the table
                    const row = document.querySelector(`tr[data-status-id="${statusId}"]`);
                    row.querySelector('input[type="text"]').value = updatedData.name;
                    row.querySelector('.dropdown-toggle').style.backgroundColor = updatedData.color;
                    row.querySelector('select').value = updatedData.state;

                    // Close the modal
                    $('#editStatusModal').modal('hide');
                } else {
                    // Handle error
                    alert('حدث خطأ أثناء تحديث الحالة');
                }
            });
        });

        // Delete Status
        document.addEventListener('click', function(e) {
            if (e.target && e.target.matches('.delete-btn')) {
                e.target.closest('tr').remove();
            }
        });

        // Initial setup for dropdowns
        setupDropdowns();
    </script>
@endsection

<style>
.custom-dropdown {
    position: relative;
}

.dropdown-toggle {
    width: 40px; /* Adjust width as needed */
    height: 40px; /* Adjust height as needed */
    border: 1px solid #ccc;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    border: 1px solid #ccc;
    z-index: 1000;
}

.dropdown-menu.show {
    display: block;
}

.color-options {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.color-option {
    width: 20px;
    height: 20px;
    cursor: pointer;
    border: 1px solid #ccc;
}
</style>
