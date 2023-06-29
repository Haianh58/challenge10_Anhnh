<?php
include 'connection.php'; // Include the connection file

if (isset($_GET['file'])) {
    $fileName = $_GET['file'];

    $sql = "SELECT * FROM files WHERE name = '$fileName'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fileData = $row['data'];

        // Set appropriate headers for download
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $fileName);
        header("Content-Length: " . strlen($fileData));

        echo $fileData;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn); // Close the database connection
?>
