<?php
require_once("connection.php");

// Xử lý khi người dùng submit form thêm sinh viên
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_student"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name =$_POST['name'];

    // Thực hiện truy vấn SQL để thêm sinh viên vào cơ sở dữ liệu
    $sql = "INSERT INTO users (username, password, name,email, phone) VALUES ('$username', '$password', '$name', '$email', '$phone')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Thêm sinh viên thành công.";
    } else {
        echo "Không thể thêm sinh viên.";
    }
}

// Hiển thị form thêm sinh viên nếu biến trạng thái là true
if (isset($_POST["add"])) {
    echo '<form method="POST" action="">';
    echo 'Username: <input type="text" name="username"><br>';
    echo 'Password: <input type="password" name="password"><br>';
    echo 'Email: <input type="email" name="email"><br>';
    echo 'Phone: <input type="text" name="phone"><br>';
    echo '<input type="submit" name="add_student" value="Add">';
    echo '</form>';
} else {
    // Hiển thị nút "Add" để điều hướng đến form thêm sinh viên
    echo '<form method="POST" action="">';
    echo '<input type="hidden" name="add" value="true">';
    echo '<input type="submit" value="Add">';
    echo '</form>';
}

?>

<!-- Thêm nút Home -->
<a href="teacher.php">Home</a>
