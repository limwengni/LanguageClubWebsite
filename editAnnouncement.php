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
$page_title = "Edit Announcement";
echo "<title>" . $page_title . "</title>";
include "helper.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $num = trim($_POST['num']);
    $club = trim($_POST['club']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $sender = trim($_POST['sender']);
    $date = trim($_POST['date']);

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
    if (empty($content)) {
        $error['content'] = 'Please insert <b>Content</b>';
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
        $sql = "UPDATE announcement SET Club=?, Title=?, Sender=?, Content=? WHERE Num= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $club, $title, $sender, $content, $num);
        $stmt->execute();

        if ($stmt->execute()) {
            echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Success!</h4>';
            echo "Announcement <strong>$title</strong> has been updated.</div>";
        } else {
            echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
            echo "<li>Record Update Error.</li>";
            echo '</ul></div>';
        }
    }
} else {
    $num = $_GET['num'] ?? '';

    $sql = "SELECT * FROM announcement WHERE num=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $num);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $num = $row['Num'];
        $club = $row['Club'];
        $title = $row['Title'];
        $sender = $row['Sender'];
        $date = $row['Date'];
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
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
        <tr>
            <th>Club ID :</th>
            <td><?= $num ?>
                <input type="hidden" 
                       name="num" 
                       value="<?= $num ?>"></td>
        </tr>
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
            <td><?= $date ?>
                <input type="hidden" 
                       name="date" 
                       value="<?= $date ?>"></td>
        </tr>
    </table>
    <input type="submit" value="Update" class="btn btn-primary">
    <a href="AnnouncementAdmin.php" class="btn btn-outline-secondary">Cancel</a>
</form>
