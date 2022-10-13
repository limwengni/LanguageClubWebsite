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
$page_title = "Delete Announcement";
echo "<title>" . $page_title . "</title>";
include "helper.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $num = trim($_POST['num']);
    $title = trim($_POST['title']);

    $sql = "DELETE FROM announcement WHERE num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $num);
    if ($stmt->execute()) {
        echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Success!</h4>';
        echo "Announcement <strong>$club</strong> has been deleted.</div>";
        echo '<a href="AnnouncementAdmin.php" class="btn btn-outline-secondary">Back to Announcement List</a>';
    } else {
        echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
        echo "<li>Record Delete Error.</li>";
        echo '</ul></div>';
    }
} else {
    $num = $_GET['num'] ?? '';

    $sql = "SELECT * FROM Announcement WHERE num=?";
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
    ?>
    <p>Are you sure that you want to delete this Announcement?</p>
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
                <td><?= $club ?>
                    <input type="hidden" 
                           name="club" 
                           value="<?= $club ?>"></td>
            </tr>
            <tr>
                <th>Title :</th>
                <td><?= $title ?>
                    <input type="hidden" 
                           name="title" 
                           value="<?= $title ?>"></td>
            </tr>
            <tr>
                <th>Sender :</th>
                <td><?= $sender ?>
                    <input type="hidden" 
                           name="sender" 
                           value="<?= $sender ?>"></td>
            </tr>
            <tr>
                <th>Date :</th>
                <td><?= $date ?>
                    <input type="hidden" 
                           name="date" 
                           value="<?= $date ?>"></td>
            </tr>

        </table>
        <input type="submit" value="Yes" class="btn btn-primary">
        <a href="AnnouncementAdmin.php" class="btn btn-outline-secondary">Cancel</a>
    </form>
    <?php
}
?>
