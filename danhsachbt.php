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

    <?php
    include 'connection.php'; // Include the connection file

    $sql = "SELECT * FROM files";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>File Name</th><th>Action</th><th>Reply File</th><th>View</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $fileName = $row['name'];
            $replyFile = $row['reply_file'];

            echo "<tr>";
            echo "<td>$fileName</td>";
            echo "<td>";
            echo "<a href='download.php?file=" . urlencode($fileName) . "'>Download</a> | ";
            echo "<a href='delete.php?file=" . urlencode($fileName) . "'>Delete</a>";
            echo "</td>";
            echo "<td>$replyFile</td>"; // Display the reply file name or value
            echo "<td>";
            echo "<a href='download_reply.php?file=" . urlencode($replyFile) . "'>View</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No files uploaded yet.";
    }

    mysqli_close($conn); // Close the database connection
    ?>
    
    <br>
    <a href="teacher.php">Home</a>
</body>

</html>
