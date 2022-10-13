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
    $MemberIC = trim($_POST['MemberIC']);
    $MemberEmail = trim($_POST['MemberEmail']);
    $MemberMobile = trim($_POST['MemberMobile']);
    $MemberPwd = trim($_POST['MemberPwd']);
    $MemberGender = trim($_POST['MemberGender']);
    $DateofBirth = trim($_POST['DateofBirth']);
    $LanguageClass = trim($_POST['LanguageClass']);
    $Reg_Date = $_POST['Reg_Date'];

    if (empty($MemberName)) {
        $error['MemberName'] = 'Please Enter a <b>Name</b>';
    }
    if (empty($MemberMobile)) {
        $error['MemberMobile'] = 'Please insert a <b>Mobile Number</b>';
    }
    if (empty($MemberPwd)) {
        $error['MemberPwd'] = 'Please insert a <b>Password</b>';
    }
    if (empty($LanguageClass)) {
        $error['Language Class'] = 'Please insert a <b>Email</b>';
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
        $sql = "UPDATE member SET MemberName=?, MemberIC=?, MemberEmail=?, MemberMobile=?, MemberPwd=?, MemberGender=?, DateOfBirth=?, LanguageClass=? WHERE MemberID= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssssi', $MemberName, $MemberIC, $MemberEmail, $MemberMobile, $MemberPwd, $MemberGender, $DateofBirth, $LanguageClass, $MemberID);
        if ($stmt->execute()) {
            echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Success!</h4>';
            echo "Member <strong>$MemberName</strong> has been updated.</div>";
        } else {
            echo '<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Opps... There are input errors!</h4><ul>';
            echo "<li>Record Update Error.</li>";
            echo '</ul></div>';
        }
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
}
?>

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
            <td>
                <input style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;"
                       name="MemberName" 
                       value="<?= $MemberName ?>">
            </td>
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
            <td><input type="tel" name="MemberMobile" id="phone" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="11" <?php echo isset($MemberMobile) ? "value= $MemberMobile" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member Password :</th>
            <td><input type="text" name="MemberPwd" id="passwordUp" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" <?php echo isset($MemberPwd) ? "value= $MemberPwd" : null ?>>
            </td>
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
            <td><select name="LanguageClass" class="form-select">
                    <option value="">-- Select One --</option>
                    <?php
                    foreach (getProgramList() as $v => $t) {
                        echo "<option value=$v>$t</option>";
                    }
                    ?></td>
        </tr>
        <tr>
            <th>Member Registration :</th>
            <td><?= $Reg_Date ?>
                <input type="hidden" 
                       name="Reg_Date" 
                       value="<?= $Reg_Date ?>"></td>
        </tr>
    </table>
    <input type="submit" value="Update" class="btn btn-primary">
    <a href="memberList.php" class="btn btn-outline-secondary">Cancel</a>
</form>
