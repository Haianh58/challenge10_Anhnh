<?php
session_start();
require_once("connection.php");

if (isset($_POST["btn_submit"])) {
    $username = $_POST["username"];
    $password = $_POST["pass"];

    if ($username == "" || $password == "") {
        echo "Bạn vui lòng nhập đầy đủ thông tin";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] == "teacher1") {
                header("Location: teacher.php");
                exit;
            } else {
                $_SESSION['username'] = $username;
                header("Location: student.php");
                exit;
            }
        } else {
            echo "Tài khoản không tồn tại.";
        }
    }
}
?>

<html>
<head>
    <title>THÔNG TIN SINH VIÊN</title>
</head>
<body>
    <form action="login.php" method="post">
        <table>
            <tr>
                <td>Username :</td>
                <td><input type="text" id="username" name="username"></td>
            </tr>
            <tr>
                <td>Password :</td>
                <td><input type="password" id="pass" name="pass"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="btn_submit" value="Đăng nhập"></td>
            </tr>
        </table>
    </form>
</body>
</html>
