<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['AdminEmail'])) {
    
} else if (isset($_SESSION['MemberEmail'])) {
    include 'logout.php';
    header("Location: login.php");
} else {
    header("Location: login.php");
}
?>

<?php
$page_title = "Insert Announcement";
echo '<title>' . $page_title . '</title>';
include "helper.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
//    $num = ($_POST['num']);
    $club = ($_POST['club']);
    $title = trim($_POST['title']);
    $sender = trim($_POST['sender']);
    $content = trim($_POST['content']);
    $date = $_POST['date'];

    if (empty($club)) {
        $error['club'] = 'Please select a <b>Club</b>';
    }
    if (empty($title)) {
        $error['title'] = 'Please select a <b>Title</b>';
    }
    if (empty($sender)) {
        $error['sender'] = 'Please select a <b>Sender</b>';
    }
    if (empty($date)) {
        $error['date'] = 'Please select a <b>Date</b>';
    }

    if (!empty($error)) {
        echo '<div class="alert alert-dismissible alert-warning">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
        foreach ($error as $e => $t) {
            echo "<li>$t</li>";
        }
        echo '</ul></div>';
    } else {
        $sql = "INSERT INTO announcement(Club, Title, Sender, Date, Content) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $club, $title, $sender, $date, $content);
        $stmt->execute();
        echo '<div class="alert alert-dismissible alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <h4 class="alert-heading">Success!</h4>';
        echo "Announcement <strong>$title</strong> has been inserted.</div>";
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'  enctype="multipart/form-data">
    <?php
    if (isset($_SESSION['AdminEmail'])) {
        
    } else if (isset($_SESSION['MemberEmail'])) {
        include 'logout.php';
        header("Location: login.php");
    } else {
        header("Location: login.php");
    }
    ?>
    <table class="table table-hover">
<!--        <tr>
            <th>Club ID :</th>
            <td>?= $num ?>
                <input type="hidden" 
                       name="num" 
                       value="?= $num ?>"></td>
        </tr>-->
        <tr>
            <th>Club :</th>
            <td><select name="club" class="form-select">
                    <option value="">-- Select One --</option>
                    <?php
                    foreach (getProgramList() as $v => $t) {
                        echo "<option value=$v>$t</option>";
                    }
                    ?></td>
        </tr>
        <tr>
            <th>Title :</th>
            <td>
                <input type="text" name="title" class="form-control" required <?php echo isset($title) ? "value=$title" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Sender :</th>
            <td>
                <input type="text" name="sender" class="form-control" required <?php echo isset($sender) ? "value=$sender" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Content :</th>
            <td>
                <input type="text" name="content" class="form-control" required <?php echo isset($content) ? "value=$content" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Date :</th>
            <td><input type="date" name="date" class="form-control" required <?php echo isset($date) ? "value=$date" : null ?>></td>
        </tr>
    </table>
    <input type="submit" value="Insert" class="btn btn-primary">
    <a href="AnnouncementAdmin.php" class="btn btn-outline-secondary">Cancel</a>
</form>
