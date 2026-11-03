<?php
require 'config.php';

class StudentCRUD {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    // CREATE - Add new student
    public function createStudent($name, $email, $roll_number, $grade, $phone) {
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $roll_number = $this->conn->real_escape_string($roll_number);
        $grade = $this->conn->real_escape_string($grade);
        $phone = $this->conn->real_escape_string($phone);
        
        if (empty($name) || empty($email) || empty($roll_number)) {
            return ["status" => "error", "message" => "Name, Email, and Roll Number are required"];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Invalid email format"];
        }
        
        $sql = "INSERT INTO students (name, email, roll_number, grade, phone) 
                VALUES ('$name', '$email', '$roll_number', '$grade', '$phone')";
        
        if ($this->conn->query($sql) === TRUE) {
            return ["status" => "success", "message" => "Student added successfully"];
        } else {
            if (strpos($this->conn->error, "Duplicate") !== false) {
                return ["status" => "error", "message" => "Roll number already exists"];
            }
            return ["status" => "error", "message" => "Error: " . $this->conn->error];
        }
    }
    
    // READ - Get all students
    public function getAllStudents() {
        $sql = "SELECT * FROM students ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
    
    // READ - Get student by ID
    public function getStudentById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM students WHERE id = '$id'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    // UPDATE - Update student
    public function updateStudent($id, $name, $email, $roll_number, $grade, $phone) {
        $id = $this->conn->real_escape_string($id);
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $roll_number = $this->conn->real_escape_string($roll_number);
        $grade = $this->conn->real_escape_string($grade);
        $phone = $this->conn->real_escape_string($phone);
        
        if (empty($name) || empty($email) || empty($roll_number)) {
            return ["status" => "error", "message" => "Name, Email, and Roll Number are required"];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Invalid email format"];
        }
        
        $sql = "UPDATE students 
                SET name='$name', email='$email', roll_number='$roll_number', 
                    grade='$grade', phone='$phone' 
                WHERE id='$id'";
        
        if ($this->conn->query($sql) === TRUE) {
            return ["status" => "success", "message" => "Student updated successfully"];
        } else {
            if (strpos($this->conn->error, "Duplicate") !== false) {
                return ["status" => "error", "message" => "Roll number already exists"];
            }
            return ["status" => "error", "message" => "Error: " . $this->conn->error];
        }
    }
    
    // DELETE - Delete student
    public function deleteStudent($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM students WHERE id='$id'";
        
        if ($this->conn->query($sql) === TRUE) {
            return ["status" => "success", "message" => "Student deleted successfully"];
        } else {
            return ["status" => "error", "message" => "Error: " . $this->conn->error];
        }
    }
    
    // Search students
    public function searchStudents($searchTerm) {
        $searchTerm = $this->conn->real_escape_string($searchTerm);
        $sql = "SELECT * FROM students 
                WHERE name LIKE '%$searchTerm%' 
                OR email LIKE '%$searchTerm%' 
                OR roll_number LIKE '%$searchTerm%'
                ORDER BY created_at DESC";
        
        $result = $this->conn->query($sql);
        $students = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $crud = new StudentCRUD($conn);
    
    switch ($action) {
        case 'add':
            $response = $crud->createStudent(
                $_POST['name'],
                $_POST['email'],
                $_POST['roll_number'],
                $_POST['grade'] ?? '',
                $_POST['phone'] ?? ''
            );
            echo json_encode($response);
            break;
            
        case 'update':
            $response = $crud->updateStudent(
                $_POST['id'],
                $_POST['name'],
                $_POST['email'],
                $_POST['roll_number'],
                $_POST['grade'] ?? '',
                $_POST['phone'] ?? ''
            );
            echo json_encode($response);
            break;
            
        case 'delete':
            $response = $crud->deleteStudent($_POST['id']);
            echo json_encode($response);
            break;
            
        case 'edit':
            $student = $crud->getStudentById($_POST['id']);
            echo json_encode($student);
            break;
            
        case 'search':
            $students = $crud->searchStudents($_POST['search']);
            echo json_encode($students);
            break;
            
        default:
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
    }
    exit();
}
?>
