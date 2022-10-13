<?php
$page_title = "Sign Up";
include 'helper.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <link rel="stylesheet" href="signup.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://bootswatch.com/5/lumen/bootstrap.min.css" rel="stylesheet">
        <script>
            function menu() {
                window.location.href = "menu.php"; //go back to menu page
            }
        </script>
    </head>
    <body style="background-color: #9891B0;">

        <!-- sql code for sign up -->
        <?php
        $name = $IC = $email = $phone = $password = $gender = $birthday = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $IC = trim($_POST['IC']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = $_POST['password'];
            $gender = $_POST['gender'];
            $birthday = $_POST['birthday'];

            //pattern
            $icpattern = "/[0-9]{6}[-][0-9]{2}-[0-9]{4}/";
            $phonepattern = "/[0][1][02-46-9][0-9]{7}|[0][1][1][0-9]{8}/";
            $passwordpattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";
            $emailpattern = "/^[\w.+\-]+@student.tarc.edu\.my$/";
            $namepattern = "/^[\w.+\-]+@student.tarc.edu\.my$/";

            if (!preg_match($icpattern, $IC)) { //if it doenst match
                $error['IC'] = 'The IC number you entered did not match the following pattern(999999-99-9999)';
            } else {
                //check IC does not repeat
                $sql = "SELECT MemberIC FROM member WHERE MemberIC = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $IC);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $error['IC'] = '<b>Member IC</b> given already exist. Try another.';
                }
            }

            if(!preg_match($emailpattern, $email)) {
                $error['email'] = 'Please use your student tarc email to register';    
            } else {
                //check email does not repeat
                $sql = "SELECT MemberEmail FROM member WHERE MemberEmail = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $error['email'] = '<b>Member Email</b> given already exist. Try another.';
                }
            }
                if (!preg_match($phonepattern, $phone)) { //if it doenst match
                    $error['phone'] = 'The <b>phone number</b> you entered did not match the following pattern(0123456789)';
                }
                if (!preg_match($passwordpattern, $password)) { //if it doenst match
                    $error['password'] = 'Your password must contain <b>at least 8 characters long</b>, <b>1 uppercase and 1 lowercase letter</b> and <b>1 number</b>';
                }
                if (empty($name)) {
                    $error['name'] = 'Please enter your <b>name</b>.';
                }
                if (empty($gender)) {
                    $error['gender'] = 'Please select your <b>gender</b>.';
                }
                if (empty($birthday)) {
                    $error['birthday'] = 'Please select your <b>birthday</b>.';
                }

                if (empty($error)) { //if no error
                    $sql = "INSERT INTO member (MemberName, MemberIC, MemberEmail, MemberMobile, MemberPwd, MemberGender, DateofBirth) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sssssss', $name, $IC, $email, $phone, $password, $gender, $birthday);
                    $stmt->execute();
                    header("Location: signupsuccess.php");
                }
            }

            mysqli_close($conn);
            ?>

            <div class="container" style="background-color: #fff; border-radius: 5px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); width: 350px; margin: 10px auto;">
                <i class="fa fa-arrow-left" id="close" style="padding-top: 10px;" onClick="menu()"/></i>

            <?php
            echo "<h1 style='padding-bottom:10px;'>$page_title</h1>";
            ?>

            <?php
            if (!empty($error)) { //if got error
                echo "<div class='errorText'>";
                foreach ($error as $e => $t) {
                    echo "<small>$t</small><br>";
                }
                echo "</div>";
            }
            ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <table class="table" style="border-collapse: collapse;">
                    <tr>
                        <td style="font-size: 15px; border: none;">Name</td>
                        <td style="border: none;"><input type="text" name="name" id="name" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="30" required <?php echo isset($name) ? "value= $name" : null ?>></td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; border: none;">IC number</td>
                        <td style="border: none;"><input type="text" name="IC" id="IC" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="14" required <?php echo isset($IC) ? "value= $IC" : null ?>>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; border: none;">Email</td>
                        <td style="border: none;"><input type="email" name="email" id="email" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" required <?php echo isset($email) ? "value= $email" : null ?>>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; border: none;">Mobile Phone</td>
                        <td style="border: none;"><input type="tel" name="phone" id="phone" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" maxlength="11" required <?php echo isset($phone) ? "value= $phone" : null ?>>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; border: none;">Password</td>
                        <td style="border: none;"><input type="password" name="password" id="passwordUp" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" required <?php echo isset($password) ? "value= $password" : null ?>>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; border: none;">Gender</td>
                        <td style="border: none;">
                            <input type="radio" name="gender" value="M" id="M" class="form-check-input" <?php echo isset($gender) ? "value= $gender" : null ?>>
                            <label for="M" class="form-check-label" style="font-size: 15px;">Male</label>
                            <input type="radio" name="gender" value="F" id="F" class="form-check-input" <?php echo isset($gender) ? "value= $gender" : null ?>>
                            <label for="F" class="form-check-label" style="font-size: 15px;">Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td  style="font-size: 15px; border: none;">Date of Birth</td>
                        <td style="border: none;">   
                            <input type="date" id="birthday" name="birthday" style="padding: 5px; font-size: 15px; border-radius: 5px; outline: none; width: 100%; border: solid 1px #ccc;" <?php echo isset($birthday) ? "value= $birthday" : null ?>>
                    </td>
                </tr>

            </table>
            <p id="terms">By creating an account you agree to our <a href="#" id="termsLink">Terms & Privacy</a>.</p>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign up</button>
            </div>
            <p id="alrAMember">Already a member? <a href="login.php" id="signInLink">Log In</a></p>

        </form>
        <script src="toggleeyesignup.js"></script>
    </div>
</body>

</html>
