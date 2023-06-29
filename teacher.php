<?php
// Kiểm tra đăng nhập giáo viên ở đây (xác thực, kiểm tra quyền truy cập, v.v.)

// Xem thông tin toàn bộ sinh viên
function viewAllStudents() {
    require_once("connection.php");
    
    // Thực hiện truy vấn SQL để lấy thông tin toàn bộ sinh viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra và hiển thị kết quả
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Student ID</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            // Hiển thị thông tin sinh viên
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['phone'] . '</td>';
            echo '<td><a href="editStudent.php?id=' . $row['id'] . '">Edit</a></td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo "Không có sinh viên nào.";
    }
    echo '<form method="POST" action="addstudent.php">';
    echo '<input type="submit" value="Add">';
    echo '</form>';
    echo '<button onclick="displayFunctionMenu()">Home</button>';

}

function viewProfile() {
    require_once("connection.php");
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            echo "Thông tin đã được cập nhật thành công.";
        } else {
            echo "Không thể cập nhật thông tin.";
        }
    }
    
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $teacher = mysqli_fetch_assoc($result);
        
        echo '<form method="POST" action="">';
        echo 'Teacher ID: ' . $teacher['id'] . '<br>';
        echo 'Name: <input type="text" name="name" value="' . $teacher['name'] . '"><br>';
        echo 'Email: <input type="email" name="email" value="' . $teacher['email'] . '"><br>';
        echo 'Phone: <input type="text" name="phone" value="' . $teacher['phone'] . '"><br>';
        echo '<input type="hidden" name="id" value="' . $teacher['id'] . '">';
        echo '<input type="submit" value="Cập nhật">';
        echo '</form>';
        echo '<button onclick="displayFunctionMenu()">Home</button>';
    } else {
        echo "Không thể lấy thông tin profile cá nhân.";
    }
}

function uploadFile($file)
{
    $targetDirectory = "uploads/"; // Thư mục lưu trữ tệp tin tải lên
    $targetFile = $targetDirectory . basename($file["name"]); // Đường dẫn đích của tệp tin
    
    // Kiểm tra nếu tệp tin đã tồn tại
    if (file_exists($targetFile)) {
        echo "Tệp tin đã tồn tại.";
        return false;
    }
    
    // Kiểm tra kích thước tệp tin
    if ($file["size"] > 500000) {
        echo "Kích thước tệp tin quá lớn.";
        return false;
    }
    
    // Kiểm tra loại tệp tin
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Chỉ cho phép tải lên các tệp tin JPG, JPEG, PNG và GIF.";
        return false;
    }
    
    // Tiến hành tải lên tệp tin
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "Tệp tin đã được tải lên thành công.";
        return true;
    } else {
        echo "Không thể tải lên tệp tin.";
        return false;
    }
// Sử dụng hàm uploadFile khi nhận được yêu cầu tải lên tệp tin
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $uploadedFile = $_FILES["file"];
    uploadFile($uploadedFile);
}
}

// Upload file bài tập
function uploadAssignment() {
    // Xử lý logic upload file bài tập vào thư mục chỉ định
    // ...
}

// Xem danh sách bài tập
function viewAssignments() {
    // Thực hiện truy vấn SQL để lấy danh sách bài tập từ cơ sở dữ liệu
    $sql = "SELECT * FROM assignments";
    // Thực thi truy vấn và xử lý kết quả
    // ...
}

// Tải file bài tập
function downloadAssignment($assignmentId) {
    // Xử lý logic tải file bài tập dựa trên $assignmentId
    // ...
}
function displayFunctionMenu() {
    echo '<h3>Chọn chức năng:</h3>';
    echo '<ul>';
    echo '<li><a href="?action=view_students">Xem thông tin toàn bộ sinh viên</a></li>';
    echo '<li><a href="?action=upload_assignment">Upload file bài tập</a></li>';
    echo '<li><a href="?action=view_assignments">Xem danh sách bài tập</a></li>';
    echo '<li><a href="?action=trochoi">Trò chơi</a></li>';
    echo '<li><a href="?action=view_Profile">profile</a></li>';
    echo '<li><a href="?action=logout">Đăng xuất</a></li>';
    // Thêm các chức năng khác vào đây
    
    echo '</ul>';
}

// Xử lý các hành động dựa trên tham số truyền vào
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'view_students') {
        viewAllStudents();
    } elseif ($action === 'upload_assignment') {
        header("Location: upload.php");
    } elseif ($action === 'view_assignments') {
        header("Location: danhsachbt.php");
    }
    elseif ($action === 'trochoi') {
        header("Location: game_gv.php");
    } elseif ($action === 'download_assignment' && isset($_GET['assignment_id'])) {
        $assignmentId = $_GET['assignment_id'];
        downloadAssignment($assignmentId);
    } elseif ($action === 'view_Profile') {
        viewProfile();  
    }
    elseif ($action === 'logout') {
        session_start(); // Start the session
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header("Location: login.php"); // Redirect to the login page
        exit(); // Stop further execution
    } else {
        displayFunctionMenu();
    }
} else {
    displayFunctionMenu();
}
?>
<script>
function displayFunctionMenu() {
    window.location.href = 'teacher.php';
}
</script>