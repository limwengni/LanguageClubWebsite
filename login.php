<?php
$page_title = "Log In";
include 'helper.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In</title>
        <link rel="stylesheet" href="login.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://bootswatch.com/5/lumen/bootstrap.min.css" rel="stylesheet">

        <script>
            function menu() {
                window.location.href = "menu.php"; //go back to menu page
            }
        </script>
    </head>
    <body style="background-color: #9891B0;">

        <!-- sql code for log in -->
        <?php
        session_start();
        $email = $password = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['emailIn']);
            $password = trim($_POST['passwordIn']);

            //pattern
            $emailpattern = "/^[\w.+\-]+@student.tarc.edu\.my$/";
            $adminpattern = "/^[\w.+\-]+@admin.tarc\.my$/";

            if (preg_match($emailpattern, $email)) { //student email
                //check if email exist or not and if exist, the password correct or not
                $sql = "SELECT * FROM member WHERE MemberEmail='$email' AND MemberPwd='$password'";
            }else if(preg_match($adminpattern, $email)){
                $sql = "SELECT * FROM admin WHERE AdminEmail='$email' AND AdminPwd='$password'";
            }

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                //if both matches, direct user(student) to membermenu page
                if ($row['MemberEmail'] === $email && $row['MemberPwd'] === $password) {
                    $_SESSION['MemberEmail'] = $row['MemberEmail'];
                    $_SESSION['MemberEmail'] = $email;
                    header("Location:menu.php");
                    exit();
                } else if ($row['AdminEmail'] === $email && $row['AdminPwd'] === $password) {
                    $_SESSION['AdminEmail'] = $row['AdminEmail'];
                    $_SESSION['AdminEmail'] = $email;
                    header("Location:dashboard.php");
                    exit();
                } else {
                    $error = 'Incorrect Email or Password';
                }
            } else {
                $error = 'Incorrect Email or Password';
            }
        }
        ?>
        <div class="container" style="background-color: #fff; border-radius: 5px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); width: 350px; margin: 10px auto;">

            <i class="fa fa-arrow-left" id="close" onClick="menu()"/></i>
        <?php
        echo "<h1 style='padding-bottom:10px;'>$page_title</h1>";
        ?>

        <?php
        if (!empty($error)) {
            echo "<div class='errorText'>";
            echo "<small>$error</small><br>";
            echo "</div>";
        }
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="textInput">
                <p id="email">
                    Email<br>
                    <input type="email" name="emailIn" id="emailIn" title="Must contain @ in email" required>
                </p>
                <p id="password">
                    Password<br>
                    <input type="password" name="passwordIn" id="passwordIn" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                </p>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
            <p id="notAMember">Not a member? <a href="signup.php" id="signUpLink">Sign up now</a></p>

        </form>
    </div>
    <script src="toggleeyelogin.js"></script>
</body>

</html>
