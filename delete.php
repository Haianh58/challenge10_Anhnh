<?php
include 'connection.php'; // Include the connection file

if (isset($_GET['file'])) {
    $fileName = $_GET['file'];

    $sql = "SELECT * FROM files WHERE name = '$fileName'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fileId = $row['id'];

        // Delete file from database
        $deleteSql = "DELETE FROM files WHERE id = $fileId";
        if (mysqli_query($conn, $deleteSql)) {
            echo "File '$fileName' deleted successfully.";
        } else {
            echo "Failed to delete file.";
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn); // Close the database connection
?>
