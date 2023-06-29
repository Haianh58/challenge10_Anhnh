<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Files</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Uploaded Files</h1>
    <table>
        <tr>
            <th>File Name</th>
            <th>Action</th>
            <th>Reply</th>
            <th>Reply File Name</th>
            <th>Delete</th>
        </tr>

        <?php
        include 'connection.php'; // Include the connection file

        $sql = "SELECT * FROM files";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $fileName = $row['name'];
                $replyFile = $row['reply_file'];
                $replyFileName = $row['reply_file'];

                echo "<tr>";
                echo "<td>$fileName</td>";
                echo "<td>";
                echo "<a href='download.php?file=" . urlencode($fileName) . "'>Download</a>";
                echo "</td>";
                echo "<td>";

                if ($replyFile) {
                    echo "<a href='downloadsv.php?file=" . urlencode($replyFile) . "'>Download Reply</a>";
                } else {
                    echo "<form method='POST' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='uploaded_file' value='$fileName'>";
                    echo "<input type='file' name='reply_file'>";
                    echo "<input type='submit' name='upload_reply' value='Upload Reply'>";
                    echo "</form>";
                }

                echo "</td>";
                echo "<td>$replyFileName</td>";
                echo "<td>";
                if ($replyFile) {
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='uploaded_file' value='$fileName'>";
                    echo "<button type='submit' name='delete_reply'>Delete</button>";
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No files uploaded yet.</td></tr>";
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["upload_reply"])) {
                if (isset($_POST["uploaded_file"]) && isset($_FILES["reply_file"])) {
                    $uploadedFile = $_POST["uploaded_file"];
                    $replyFile = $_FILES["reply_file"];
                    $uploadResult = uploadReply($uploadedFile, $replyFile);

                    if ($uploadResult) {
                        echo "Reply uploaded successfully for '$uploadedFile'.<br>";
                        echo "<meta http-equiv='refresh' content='0'>"; // Refresh the page to display the updated reply
                    } else {
                        echo "Failed to upload reply.";
                    }
                }
            } elseif (isset($_POST["delete_reply"])) {
                $uploadedFile = $_POST["uploaded_file"];
                $deleteResult = deleteReply($uploadedFile);

                if ($deleteResult) {
                    echo "Reply file deleted successfully for '$uploadedFile'.<br>";
                    echo "<meta http-equiv='refresh' content='0'>"; // Refresh the page to display the updated reply
                } else {
                    echo "Failed to delete reply file.";
                }
            }
        }

        function uploadReply($uploadedFile, $replyFile)
        {
            global $conn;

            $fileName = mysqli_real_escape_string($conn, $replyFile["name"]);
            $fileData = mysqli_real_escape_string($conn, file_get_contents($replyFile["tmp_name"]));

            $sql = "UPDATE files SET reply_file=?, data_reply=?, reply_file=? WHERE name=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $fileName, $fileData, $fileName, $uploadedFile);

            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return false;
            }
        }

        function deleteReply($uploadedFile)
        {
            global $conn;

            $sql = "UPDATE files SET reply_file=NULL, data_reply=NULL, reply_file=NULL WHERE name=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $uploadedFile);

            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return false;
            }
        }
        ?>

    </table>

    <a href="student.php">Home</a>
</body>
</html>
