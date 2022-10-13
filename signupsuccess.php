<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://bootswatch.com/5/lumen/bootstrap.min.css" rel="stylesheet">
        <script>
            function login() {
                window.location.href = "login.php"; //go back to menu page
            }
        </script>
    </head>
    <body style="background-color: #9891B0;">        
        <div class="container" style="background-color: #fff; border-radius: 5px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); width: 350px; margin: 10px auto;">
            <div id="upper-side">
                <h1 id="status">SUCCESS!</h1>
            </div>
            <?php
            echo "<div class='successText'>";
            echo "Congratulations, your account has been successfully created.";
            echo "</div>";
            ?>
            <div class="col-12">
                <button onClick="login()" class="btn btn-primary">Log In</button>
            </div>
        </div>
    </body>
