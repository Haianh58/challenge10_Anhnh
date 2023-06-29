<!DOCTYPE html>
<html>

<head>
    <title>Upload File</title>
</head>

<body>
    
    <h1>Upload File</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="upload" value="Upload">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload"])) {
        if (isset($_FILES["file"])) {
            $uploadedFile = $_FILES["file"];
            $uploadResult = uploadFile($uploadedFile);

            if ($uploadResult) {
                echo "File uploaded successfully.<br>";
                echo "Uploaded file: " . $uploadedFile["name"] . "<br>";
                echo '<a href="download.php?file=' . urlencode($uploadedFile["name"]) . '">Download file</a>';
            } else {
                echo "Failed to upload file.";
            }
        }
    }

    function uploadFile($file)
    {
        include 'connection.php'; // Include the connection file

        $fileName = mysqli_real_escape_string($conn, $file["name"]);
        $fileData = mysqli_real_escape_string($conn, file_get_contents($file["tmp_name"]));

        $sql = "INSERT INTO files (name, data) VALUES ('$fileName', '$fileData')";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return false;
        }
    }
    ?>
</body>

</html>
<a href="teacher.php">Home</a>
