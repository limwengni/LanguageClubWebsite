<?php
include 'helper.php';
include 'header.php';
// If file upload form is submitted 
$status = $statusMsg = '';
if (isset($_POST["submit"])) {
    $status = 'error';
    $id = trim($_POST['id']);
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Insert image content into database 
            $sql = "UPDATE member SET ProfilePicture = '$imgContent' WHERE MemberID = '$id'";
            $result = $conn->query($sql);

            if ($result === TRUE) {
                header("Location: profile.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                $statusMsg = "File upload failed, please try again.";
                echo "<div style='color: #D8000C; text-align: center;'>";
                echo $statusMsg;
                echo "</div>";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            echo "<div style='color: #D8000C; text-align: center;'>";
            echo $statusMsg;
            echo "</div>";
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
        echo "<div style='color: #D8000C; text-align: center;'>";
        echo $statusMsg;
        echo "</div>";
    }
} else {
    $id = $_GET['id'] ?? '';
}

$page_title = "Edit Image";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Image</title>
        <link rel="stylesheet" href="edit.css" />
    </head>
    <body>
        <div id="content">
            <div class="editInfo">
                <?php echo "<h4>$page_title</h4><div class = 'sDivider'></div>" ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <table class="table" style="border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 15px; border: none;">ID</td>
                            <td style="border: none;"><?= $id ?>
                                <input type='hidden' name="id" 
                                       value="<?= $id ?>">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Select Image File:</td>
                            <td>
                                <input class="form-control" type="file" name="image" id="formFile">
                            </td>
                        </tr>
                        <tr>
                        <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed.</p>
                        </tr>
                    </table>
                    <button class="btn btn-info" type="submit" name="submit" value="Upload" style="width: 120px">Continue</button>
                    <a href="profile.php" class="btn btn-danger" style="width: 120px">Cancel</a>
                </form>
            </div>
        </div>
    </body>
</html>
