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
$page_title = "Insert Member";
include "helper.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
//$MemberID = ($_POST['MemberID']);
    $MemberName = trim($_POST['MemberName']);
    $MemberIC = trim($_POST['MemberIC']);
    $MemberEmail = trim($_POST['MemberEmail']);
    $MemberMobile = trim($_POST['MemberMobile']);
    $MemberPwd = trim($_POST['MemberPwd']);
    $MemberGender = trim($_POST['MemberGender']);
    $DateofBirth = trim($_POST['DateofBirth']);
    $LanguageClass = trim($_POST['LanguageClass']);

    $icpattern = "/[0-9]{6}[-][0-9]{2}-[0-9]{4}/";
    $phonepattern = "/[0][1][02-46-9][0-9]{7}|[0][1][1][0-9]{8}/";
    $passwordpattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";
    $emailpattern = "/^[\w.+\-]+@student.tarc.edu\.my$/";
    $namepattern = "/^[\w.+\-]+@student.tarc.edu\.my$/";

    if (!preg_match($icpattern, $MemberIC)) { //if it doenst match
        $error['IC'] = 'The IC number you entered did not match the following pattern(999999-99-9999)';
    } else {
//check IC does not repeat
        $sql = "SELECT MemberIC FROM member WHERE MemberIC = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $MemberIC);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error['IC'] = '<b>Member IC</b> given already exist. Try another.';
        }
    }

    if (!preg_match($emailpattern, $MemberEmail)) {
        $error['email'] = 'Please use your student tarc email to register';
    } else {
//check email does not repeat
        $sql = "SELECT MemberEmail FROM member WHERE MemberEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $MemberEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error['email'] = '<b>Member Email</b> given already exist. Try another.';
        }
    }
    if (!preg_match($phonepattern, $MemberMobile)) { //if it doenst match
        $error['phone'] = 'The <b>phone number</b> you entered did not match the following pattern(0123456789)';
    }
    if (!preg_match($passwordpattern, $MemberPwd)) { //if it doenst match
        $error['password'] = 'Your password must contain <b>at least 8 characters long</b>, <b>1 uppercase and 1 lowercase letter</b> and <b>1 number</b>';
    }
    if (empty($MemberName)) {
        $error['name'] = 'Please enter your <b>name</b>.';
    }
    if (empty($MemberGender)) {
        $error['gender'] = 'Please select your <b>gender</b>.';
    }
    if (empty($LanguageClass)) {
        $error['class'] = 'Please select your <b>language class</b>.';
    }
    if (empty($DateofBirth)) {
        $error['birthday'] = 'Please select your <b>birthday</b>.';
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
        $sql = "INSERT INTO member(MemberName, MemberIC, MemberEmail, MemberMobile, MemberPwd, MemberGender, DateofBirth, LanguageClass) VALUES (?,?,?,?,?,?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', $MemberName, $MemberIC, $MemberEmail, $MemberMobile, $MemberPwd, $MemberGender, $DateofBirth, $LanguageClass);
        $stmt->execute();
        echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Success!</h4>';
        echo "Member <strong>$MemberName</strong> has been inserted.</div>";
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
    <table class="table table-hover">

        <tr>
            <th>Member Name :</th>
            <td>
                <input type="text" name="MemberName" class="form-control" required <?php echo isset($MemberName) ? "value=$MemberName" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member IC :</th>
            <td>
                <input type="text" name="MemberIC" class="form-control" required <?php echo isset($MemberIC) ? "value=$MemberIC" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member Email :</th>
            <td>
                <input type="text" name="MemberEmail" class="form-control" required <?php echo isset($MemberEmail) ? "value=$MemberEmail" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member Mobile :</th>
            <td>
                <input type="text" name="MemberMobile" class="form-control" required <?php echo isset($MemberMobile) ? "value=$MemberMobile" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member Password :</th>
            <td>
                <input type="text" name="MemberPwd" class="form-control" required <?php echo isset($MemberPwd) ? "value=$MemberPwd" : null ?>>
            </td>
        </tr>
        <tr>
            <th>Member Gender :</th>
            <td><select name="MemberGender" class="form-select">
                    <option value="">-- Select One --</option>
                    <?php
                    foreach (getGenderList() as $v => $t) {
                        echo "<option value=$v>$t</option>";
                    }
                    ?></td>
        </tr>
        <tr>
            <th>Date of Birth:</th>
            <td><input type="date" name="DateofBirth" class="form-control" required <?php echo isset($DateofBirth) ? "value=$DateofBirth" : null ?>></td>
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

    </table>
    <input type="submit" value="Insert" class="btn btn-primary">
    <a href="memberList.php" class="btn btn-outline-secondary">Return to List</a>
</form>
