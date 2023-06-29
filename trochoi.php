<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Minigame - Trò chơi</title>
</head>
<body>
    <?php
    include 'connection.php';

    // Kiểm tra xem người dùng đã nhập đáp án hay chưa
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
        $answer = $_POST['answer'];

        // Lấy tên file từ tham số URL
        $filename = $_GET['filename'];

        // Kiểm tra đáp án
        $sql = "SELECT * FROM challenges WHERE filename = '$filename' AND answer = '$answer'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Đáp án đúng, lấy và hiển thị nội dung từ trường data
            $challenge = mysqli_fetch_assoc($result);
            $file_content = $challenge['data'];
            echo "<pre>$file_content</pre>";
        } else {
            echo "Đáp án không chính xác!";
        }
    }
    ?>

    <!-- Form nhập đáp án -->
    <h3>Nhập đáp án</h3>
    <form method="post">
        Đáp án: <input type="text" name="answer" required><br><br>
        <input type="submit" value="Kiểm tra">
    </form>
</body>
</html>
<a href="game_sv.php">Home</a>