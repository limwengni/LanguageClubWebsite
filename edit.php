<?php
include 'header.php';
include 'helper.php';
// If file upload form is submitted 
$status = '';
$phone = $password = "";
$phonepattern = "/[0][1][02-46-9][0-9]{7}|[0][1][1][0-9]{8}/";
$passwordpattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// If upload button is clicked ...
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $ic = trim($_POST['ic']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $DOB = $_POST['dob'];

    if (empty($name)) {
        $error['name'] = 'Please enter your <b>name</b>.';
    }

    if (!preg_match($phonepattern, $phone)) { //if it doenst match
        $error['phone'] = 'The <b>phone number</b> you entered did not match the following pattern(0123456789)';
    }
    
    if (!preg_match($passwordpattern, $password)) { //if it doenst match
        $error['password'] = 'Your password must contain <b>at least 8 characters long</b>, <b>1 uppercase and 1 lowercase letter</b> and <b>1 number</b>';
    }

    if (empty($error)) { //if no error
        // Get all the submitted data from the form
        $sql = "UPDATE member SET MemberName = '$name', MemberMobile = '$phone', MemberPwd = '$password' WHERE MemberID = '$id'";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            header("Location: profile.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<div class='errorText'>";
        foreach ($error as $e => $t) {
            echo "$t<br>";
        }
        echo "</div>";
    }
} else {
    $id = $_GET['id'] ?? '';

    $sql = "SELECT memberID AS ID, memberName AS Name, memberIC AS IC, memberEmail AS Email, memberMobile AS MobilePhone, memberPwd AS Password, memberGender AS Gender, dateofbirth AS DOB FROM member WHERE memberID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $c0 = 'ID';
    $c1 = 'Name';
    $c2 = 'IC';
    $c3 = 'Email';
    $c4 = 'MobilePhone';
    $c5 = 'Password';
    $c6 = 'Gender';
    $c7 = 'DOB';
    if ($result->num_rows > 0) {
        while ($col = $result->fetch_assoc()) {
            $id = $col[$c0];
            $name = $col[$c1];
            $ic = $col[$c2];
            $email = $col[$c3];
            $phone = $col[$c4];
            $password = $col[$c5];
            $gender = getGender($col[$c6]);
            $genderIcon = getGenderIcon($col[$c6]);
            $DOB = $col[$c7];
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        $page_title = "Edit Profile";
        ?>
        <title><?php echo $page_title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="edit.css" />
    </head>

    <body>

        <div id="content">
            <div class ="editInfo">
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['MemberEmail'])) {
                    
                } else {
                    header("Location: login.php");
                }
                ?>
                <?php echo "<h4>$page_title</h4><div class = 'sDivider'></div>" ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <table class="table" style="border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 15px; border: none;">ID</td>
                            <td style="border: none;"><?= $id ?>
                                <input type='hidden' name="id" 
                                       value="<?= $id ?>"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Name</td>
                            <td style="border: none;">
                                <input style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;"
                                       name="name" 
                                       value="<?= $name ?>">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">IC</td>
                            <td style="border: none;"><?= $ic ?>
                                <input type="hidden" name="ic" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" <?php echo isset($ic) ? "value= $ic" : null ?>>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Email</td>
                            <td style="border: none;"><?= $email ?>
                                <input type="hidden" name="email" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" <?php echo isset($email) ? "value= $email" : null ?>>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Mobile Phone</td>
                            <td style="border: none;"><input type="tel" name="phone" id="phone" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="11" <?php echo isset($phone) ? "value= $phone" : null ?>>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Password</td>
                            <td style="border: none;"><input type="text" name="password" id="passwordUp" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" <?php echo isset($password) ? "value= $password" : null ?>>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Gender</td>
                            <td style="border: none;"><?= $gender ?>
                                <input type="hidden" name="gender" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="11" <?php echo isset($gender) ? "value= $gender" : null ?>>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; border: none;">Date of Birth</td>
                            <td style="border: none;"><?= $DOB ?>
                                <input type="hidden" name="dob" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="11" <?php echo isset($DOB) ? "value= $DOB" : null ?>>
                            </td>
                        </tr>

                    </table>
                    <div class="form-group">
                        <button class="btn btn-info" type="submit" name="upload" style="width: 120px">Continue</button>
                        <a href="profile.php" class="btn btn-danger" style="width: 120px">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>
<!--
                        <div id="display-image">

                            $query = "select profilePicture from member";
                            $result = $conn->query($query);

                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                <img src="./image/ echo $data['profilePicture']; ?>">


                            }
                            ?>
                        </div>-->