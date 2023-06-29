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
        echo '</tr>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            // Hiển thị thông tin sinh viên
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['phone'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo "Không có sinh viên nào.";
    }
    echo '<button onclick="displayFunctionMenu()">Home</button>';

}

function viewProfile() {
    require_once("connection.php");
    
    session_start(); // Start the session
    
    // Check if the user is logged in and the session variable is set
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            echo '<form method="POST" action="">';
            echo 'User ID: ' . $user['id'] . '<br>';
            echo 'Username: ' . $user['username'] . '<br>';
            echo 'Name: <input type="text" name="name" value="' . $user['name'] . '"><br>';
            echo 'Email: <input type="email" name="email" value="' . $user['email'] . '"><br>';
            echo 'Phone: <input type="text" name="phone" value="' . $user['phone'] . '"><br>';
            echo '<input type="submit" value="Cập nhật">';
            
            echo '</form>';
            
            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                
                $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);
                
                if ($result) {
                    echo "Thông tin đã được cập nhật thành công.";
                } else {
                    echo "Không thể cập nhật thông tin.";
                }
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }
    
    echo '<button onclick="displayFunctionMenu()">Home</button>';
}

function logout() {
    session_start(); // Start the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit(); // Stop further execution
}

function displayFunctionMenu() {
    echo '<h3>Chọn chức năng:</h3>';
    echo '<ul>';
    echo '<li><a href="?action=view_students">Xem thông tin toàn bộ sinh viên</a></li>';
    echo '<li><a href="?action=view_assignments">Xem danh sách bài tập</a></li>';
    echo '<li><a href="?action=trochoi">Trò chơi</a></li>';
    echo '<li><a href="?action=view_profile">Profile</a></li>';
    echo '<li><a href="?action=logout">Đăng xuất</a></li>';
    // Thêm các chức năng khác vào đây
    
    echo '</ul>';
}

// Xử lý các hành động dựa trên tham số truyền vào
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'view_students') {
        viewAllStudents();
    } elseif ($action === 'view_assignments') {
        header("Location: dsbtsv.php");
    } elseif ($action === 'view_profile') {
        viewProfile();
    }
    elseif ($action === 'trochoi') {
        header("Location:game_sv.php");
    } elseif ($action === 'logout') {
        logout();
    } else {
        displayFunctionMenu();
    }
} else {
    displayFunctionMenu();
}
?>

<script>
function displayFunctionMenu() {
    window.location.href = 'student.php';
}
</script>
