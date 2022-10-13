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
$page_title = "Update Member";
echo "<title>" . $page_title . "</title>";
include "helper.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $MemberID = ($_POST['MemberID']);
    $MemberName = trim($_POST['MemberName']);

    $sql = "DELETE FROM member WHERE MemberID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $MemberID);
    if ($stmt->execute()) {
        echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Success!</h4>';
        echo "Member <strong>$MemberName</strong> has been deleted.</div>";
        echo '<a href="memberList.php" class="btn btn-outline-secondary">Back to Member List</a>';
    } else {
        echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
        echo "<li>Record Delete Error.</li>";
        echo '</ul></div>';
    }
} else {
    $MemberID = $_GET['id'] ?? '';

    $sql = "SELECT * FROM member WHERE MemberID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $MemberID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $MemberID = $row['MemberID'];
        $MemberName = $row['MemberName'];
        $MemberIC = $row['MemberIC'];
        $MemberEmail = $row['MemberEmail'];
        $MemberMobile = $row['MemberMobile'];
        $MemberPwd = $row['MemberPwd'];
        $MemberGender = $row['MemberGender'];
        $DateofBirth = $row['DateofBirth'];
        $LanguageClass = $row['LanguageClass'];
        $Reg_Date = $row['Reg_Date'];
    }
    ?>
    <p>Are you sure that you want to delete this Announcement?</p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>

        <table class="table table-hover">
            <tr>
                <th>Member ID :</th>
                <td><?= $MemberID ?>
                    <input type="hidden" 
                           name="MemberID" 
                           value="<?= $MemberID ?>"></td>
            </tr>
            <tr>
                <th>Member Name :</th>
                <td><?= $MemberName ?>
                    <input type="hidden" 
                           name="MemberName" 
                           value="<?= $MemberName ?>"></td>
            </tr>
            <tr>
                <th>Member IC :</th>
                <td><?= $MemberIC ?>
                    <input type="hidden" 
                           name="MemberIC" 
                           value="<?= $MemberIC ?>"></td>
            </tr>
            <tr>
                <th>Member Email :</th>
                <td><?= $MemberEmail ?>
                    <input type="hidden" 
                           name="MemberEmail" 
                           value="<?= $MemberEmail ?>"></td>
            </tr>
            <tr>
                <th>Member Mobile :</th>
                <td><?= $MemberMobile ?>
                    <input type="hidden" 
                           name="MemberMobile" 
                           value="<?= $MemberMobile ?>"></td>
            </tr>
            <tr>
                <th>Member Password :</th>
                <td><?= $MemberPwd ?>
                    <input type="hidden" 
                           name="MemberPwd" 
                           value="<?= $MemberPwd ?>"></td>
            </tr>
            <tr>
                <th>Member Gender :</th>
                <td><?= $MemberGender ?>
                    <input type="hidden" 
                           name="MemberGender" 
                           value="<?= $MemberGender ?>"></td>
            </tr>
            <tr>
                <th>Member Birth Date :</th>
                <td><?= $DateofBirth ?>
                    <input type="hidden" 
                           name="DateofBirth" 
                           value="<?= $DateofBirth ?>"></td>
            </tr>
            <tr>
                <th>Language Class :</th>
                <td><?= $LanguageClass ?>
                    <input type="hidden" 
                           name="LanguageClass" 
                           value="<?= $LanguageClass ?>"></td>
            </tr>
            <tr>
                <th>Registration Date :</th>
                <td><?= $Reg_Date ?>
                    <input type="hidden" 
                           name="Reg_Date" 
                           value="<?= $Reg_Date ?>"></td>
            </tr>

        </table>
        <input type="submit" value="Yes" class="btn btn-primary">
        <a href="memberList.php" class="btn btn-outline-secondary">Cancel</a>
    </form>
    <?php
}
?>