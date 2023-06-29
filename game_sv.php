<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Minigame - Sinh viên</title>
</head>
<body>
    <?php
    include 'connection.php';

    // Lấy danh sách các câu hỏi
    $sql = "SELECT * FROM challenges";
    $result = mysqli_query($conn, $sql);
    $challenges = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <!-- Hiển thị bảng các câu hỏi -->
    <h3>Các câu hỏi</h3>
    <table>
        <tr>
            <th>Câu hỏi</th>
            <th>Gợi ý</th>
        </tr>
        <?php foreach ($challenges as $challenge): ?>
            <tr>
                <td><a href="trochoi.php?filename=<?php echo $challenge['filename']; ?>"><?php echo $challenge['filename']; ?></a></td>
                <td><?php echo $challenge['hint']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="student.php">Home</a>
</body>
</html>
