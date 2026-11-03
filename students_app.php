<?php
require 'config.php';
require 'crud.php';

$crud = new StudentCRUD($conn);
$students = $crud->getAllStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container-main {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }
        
        .header h1 {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .btn-custom {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }
        
        .form-section h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .table-section {
            margin-top: 30px;
        }
        
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .table tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: black;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #e0a800;
            color: black;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
        }
        
        .alert-message {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 12px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .search-box {
            margin-bottom: 20px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Student Record Management System</h1>
            <p class="text-muted">Manage student information efficiently</p>
        </div>
        
        <div id="alertMessage"></div>
        
        <!-- Add/Edit Student Form -->
        <div class="form-section">
            <h3><i class="fas fa-user-plus"></i> Add New Student</h3>
            <form id="studentForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Roll Number *</label>
                        <input type="text" class="form-control" id="roll_number" name="roll_number" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Grade</label>
                        <select class="form-control" id="grade" name="grade">
                            <option value="">Select Grade</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                </div>
                <input type="hidden" id="studentId" name="id">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom btn-custom" id="submitBtn">
                        <i class="fas fa-save"></i> Add Student
                    </button>
                    <button type="reset" class="btn btn-secondary btn-custom" id="resetBtn" style="border-radius: 25px;">
                        <i class="fas fa-redo"></i> Clear
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Search and Filter -->
        <div class="search-box">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name, email, or roll number...">
        </div>
        
        <!-- Students Table -->
        <div class="table-section">
            <h3><i class="fas fa-list"></i> Students List</h3>
            <div class="table-responsive">
                <table class="table table-hover" id="studentTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roll Number</th>
                            <th>Grade</th>
                            <th>Phone</th>
                            <th>Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Populated by JavaScript -->
                    </tbody>
                </table>
                <div id="emptyState" class="empty-state" style="display: none;">
                    <i class="fas fa-inbox"></i>
                    <p>No students found</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load students on page load
        loadStudents();
        
        // Form submission
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const studentId = document.getElementById('studentId').value;
            const action = studentId ? 'update' : 'add';
            
            const formData = new FormData(this);
            formData.append('action', action);
            
            fetch('crud.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showAlert(data.message, data.status);
                if (data.status === 'success') {
                    document.getElementById('studentForm').reset();
                    document.getElementById('studentId').value = '';
                    document.getElementById('submitBtn').textContent = '✓ Add Student';
                    loadStudents();
                }
            })
            .catch(error => showAlert('Error: ' + error, 'error'));
        });
        
        // Load all students
        function loadStudents() {
            const students = <?php echo json_encode($students); ?>;
            displayStudents(students);
        }
        
        // Display students in table
        function displayStudents(students) {
            const tbody = document.getElementById('tableBody');
            const emptyState = document.getElementById('emptyState');
            
            tbody.innerHTML = '';
            
            if (students.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            students.forEach(student => {
                const row = `
                    <tr>
                        <td>${student.id}</td>
                        <td><strong>${student.name}</strong></td>
                        <td>${student.email}</td>
                        <td>${student.roll_number}</td>
                        <td><span class="badge bg-info">${student.grade || '-'}</span></td>
                        <td>${student.phone || '-'}</td>
                        <td><small class="text-muted">${new Date(student.created_at).toLocaleDateString()}</small></td>
                        <td>
                            <button class="btn btn-sm btn-edit" onclick="editStudent(${student.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-delete" onclick="deleteStudent(${student.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
        
        // Edit student
        function editStudent(id) {
            const formData = new FormData();
            formData.append('action', 'edit');
            formData.append('id', id);
            
            fetch('crud.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(student => {
                document.getElementById('name').value = student.name;
                document.getElementById('email').value = student.email;
                document.getElementById('roll_number').value = student.roll_number;
                document.getElementById('grade').value = student.grade;
                document.getElementById('phone').value = student.phone;
                document.getElementById('studentId').value = student.id;
                document.getElementById('submitBtn').textContent = '✓ Update Student';
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(error => showAlert('Error: ' + error, 'error'));
        }
        
        // Delete student
        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                fetch('crud.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showAlert(data.message, data.status);
                    if (data.status === 'success') {
                        loadStudents();
                    }
                })
                .catch(error => showAlert('Error: ' + error, 'error'));
            }
        }
        
        // Search students
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value;
            
            if (searchTerm === '') {
                loadStudents();
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'search');
            formData.append('search', searchTerm);
            
            fetch('crud.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => displayStudents(data))
            .catch(error => showAlert('Error: ' + error, 'error'));
        });
        
        // Show alert
        function showAlert(message, type) {
            const alertDiv = document.getElementById('alertMessage');
            const className = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            
            alertDiv.innerHTML = `
                <div class="alert alert-message ${className} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${icon}"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            setTimeout(() => {
                alertDiv.innerHTML = '';
            }, 4000);
        }
    </script>
</body>
</html>
