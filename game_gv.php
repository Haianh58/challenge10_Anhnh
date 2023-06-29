<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Minigame</title>
</head>
<body>
    <?php
    include 'connection.php';

    // Xử lý khi giáo viên tạo challenge
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['challenge'])) {
        $file = $_FILES['file'];
        $filename = $_POST['filename'];
        $hint = $_POST['hint'];
        $answer = $_POST['answer'];

        // Kiểm tra có file được tải lên không
        if (!empty($file['name'])) {
            $file_data = file_get_contents($file['tmp_name']);
            $file_data = mysqli_real_escape_string($conn, $file_data);

            // Lưu thông tin thử thách vào cơ sở dữ liệu
            $sql = "INSERT INTO challenges (data, filename, hint, answer) VALUES ('$file_data', '$filename', '$hint', '$answer')";
            if (mysqli_query($conn, $sql)) {
                echo "Thử thách đã được tạo thành công!";
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        } else {
            echo "Vui lòng tải lên một file!";
        }
    }
    ?>

    <!-- Form để giáo viên tạo challenge -->
    <h3>Tạo challenge</h3>
    <form method="post" enctype="multipart/form-data">
        Tên câu hỏi: <input type="text" name="filename" required><br><br>
        <input type="file" name="file" accept=".txt" required><br><br>
        Gợi ý: <input type="text" name="hint" required><br><br>
        Đáp án: <input type="text" name="answer" required><br><br>
        <input type="submit" name="challenge" value="Tạo challenge">
    </form>
    <a href="teacher.php">Home</a>
</body>
</html>
