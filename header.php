<?php
//header.php
//connect database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "language";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Header</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://bootswatch.com/5/united/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body{
                font-family: sans-serif;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['MemberEmail'])) {
            echo'<nav class = "navbar navbar-expand-lg navbar-dark" style = "background-color: #9891B0; position: sticky; width: 100%; top: 0; z-index: 1;">';
            echo'<div class = "container-fluid">';
            echo'<a href = "menu.php"><img src = "TARC logo.png" class = "navbar-brand" style = "width:120px; height:90px;"></a>';
            echo'<button class = "navbar-toggler" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navbarColor01" aria-controls = "navbarColor01" aria-expanded = "true" aria-label = "Toggle navigation">';
            echo'<span class = "navbar-toggler-icon"></span>';
            echo'</button>';
            echo'<div class = "navbar-collapse collapse show" id = "navbarColor01">';
            echo'<ul class = "navbar-nav me-auto">';
            echo'<li class = "nav-item">';
            echo '<a class = "nav-link active" href = "menu.php">Home';
            echo '<span class = "visually-hidden">(current)</span>';
            echo '</a>';
            echo '</li>';
            echo '<li class = "nav-item">';
            echo '<a class = "nav-link" href = "aboutus.php">About Us</a>';
            echo '</li>';
            echo '<li class = "nav-item dropdown">';
            echo '<a class = "nav-link dropdown-toggle" data-bs-toggle = "dropdown" href = "event.php" role = "button" aria-haspopup = "true" aria-expanded = "false">Events</a>';
            echo '<div class = "dropdown-menu">';
            $sql2 = "SELECT Event_Name AS Name, PageLink AS Link from event";
            $result2 = $conn->query($sql2);
            $c3 = 'Name';
            $c4 = 'Link';
            while ($row = $result2->fetch_assoc()) {
                echo "<a class = 'dropdown-item' href = '$row[$c4]'>" . $row[$c3] . '</a>';
            }
            echo '</div>';
            echo '</li>';
            echo '</ul>';

            echo'<ul class = "nav navbar-nav ml-auto">';
            echo '<li class = "nav-item dropdown">';
            $email = $_SESSION['MemberEmail'];
            $sql = "SELECT memberName AS Name, memberGender AS Gender, ProfilePicture AS PFP from Member WHERE memberEmail = '$email'";
            $result = $conn->query($sql);
            $c0 = 'Name';
            $c1 = 'PFP';
            $c2 = 'Gender';
            if ($result->num_rows > 0) {
                while ($col = $result->fetch_assoc()) {
                    echo '<a class = "nav-link dropdown-toggle" data-bs-toggle = "dropdown" href = "#" role = "button" aria-haspopup = "true" aria-expanded = "false" style="padding-right: 40px;">';
                    echo "Welcome,";
//                    $genderPronoun = getGenderPronoun($col[$c2]);
                    echo "<br>$col[$c0]</a>";
                    echo '<div class = "dropdown-menu">';
                    echo '<a class = "dropdown-item" href = "profile.php"><span class = "fas fa-user"></span> Profile</a>';
                    echo '<a class = "dropdown-item" href = "announcement.php"><span class = "fas fa-bullhorn"></span> Announcement</a>';
                    echo '<a class = "dropdown-item" href = "logout.php"><span class = "fas fa-sign-out-alt"></span> Log Out</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '</ul>';
                }
            }
        } else if (isset($_SESSION['AdminEmail'])) {
            echo'<nav class = "navbar navbar-expand-lg navbar-dark" style = "background-color: #9891B0; position: sticky; width: 100%; top: 0; z-index: 1;">';
            echo'<div class = "container-fluid">';
            echo'<a href = "dashboard.php"><img src = "TARC logo.png" class = "navbar-brand" style = "width:120px; height:90px;"></a>';
            echo'<button class = "navbar-toggler" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navbarColor01" aria-controls = "navbarColor01" aria-expanded = "true" aria-label = "Toggle navigation">';
            echo'<span class = "navbar-toggler-icon"></span>';
            echo'</button>';
            echo'<div class = "navbar-collapse collapse show" id = "navbarColor01">';
            echo'<ul class = "navbar-nav me-auto">';
            echo'<li class = "nav-item">';
            echo '<a class = "nav-link active" href = "dashboard.php">Dashboard';
            echo '<span class = "visually-hidden">(current)</span>';
            echo '</a>';
            echo '</li>';
            echo '<li class = "nav-item">';
            echo '<a class = "nav-link" href = "AnnouncementAdmin.php">Announcement</a>';
            echo '</li>';
            echo '</ul>';

            echo'<ul class = "nav navbar-nav ml-auto">';
            echo '<li class = "nav-item dropdown">';
            $email = $_SESSION['AdminEmail'];
            $sql = "SELECT adminName AS Name from Admin WHERE adminEmail = '$email'";
            $result = $conn->query($sql);
            $c0 = 'Name';
            if ($result->num_rows > 0) {
                while ($col = $result->fetch_assoc()) {
                    echo '<a class = "nav-link dropdown-toggle" data-bs-toggle = "dropdown" href = "#" role = "button" aria-haspopup = "true" aria-expanded = "false" style="padding-right: 40px;">';
                    echo "Welcome,";
                    echo "<br>$col[$c0]</a>";
                    echo '<div class = "dropdown-menu">';
                    echo '<a class = "dropdown-item" href = "memberList.php"><span class = "fas fa-list"></span> Member List</a>';
                    echo '<a class = "dropdown-item" href = "logout.php"><span class = "fas fa-sign-out-alt"></span> Log Out</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '</ul>';

//                    echo '<ul class = "nav navbar-nav ml-auto">';
//                    echo '<li class="nav-item">';
//                    echo '<a class = "nav-link" href = "memberList.php"><span class = "fas fa-list"></span> Member List</a>';
//                    echo '</li>';
//                    echo '<li class = "nav-item">';
//                    echo '<a class = "nav-link" value = "logout" href = "logout.php"><span class = "fas fa-sign-out-alt"></span> Log Out</a>';
//                    echo '</li>';
                }
            }
        } else {
            echo'<nav class = "navbar navbar-expand-lg navbar-dark" style = "background-color: #9891B0; position: sticky; width: 100%; top: 0; z-index: 1;">';
            echo'<div class = "container-fluid">';
            echo'<a href = "menu.php"><img src = "TARC logo.png" class = "navbar-brand" style = "width:120px; height:90px;"></a>';
            echo'<button class = "navbar-toggler" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navbarColor01" aria-controls = "navbarColor01" aria-expanded = "true" aria-label = "Toggle navigation">';
            echo'<span class = "navbar-toggler-icon"></span>';
            echo'</button>';
            echo'<div class = "navbar-collapse collapse show" id = "navbarColor01">';
            echo'<ul class = "navbar-nav me-auto">';
            echo'<li class = "nav-item">';
            echo '<a class = "nav-link active" href = "menu.php">Home';
            echo '<span class = "visually-hidden">(current)</span>';
            echo '</a>';
            echo '</li>';
            echo '<li class = "nav-item">';
            echo '<a class = "nav-link" href = "aboutus.php">About Us</a>';
            echo '</li>';
            echo '<li class = "nav-item dropdown">';
            echo '<a class = "nav-link dropdown-toggle" data-bs-toggle = "dropdown" href = "event.php" role = "button" aria-haspopup = "true" aria-expanded = "false">Events</a>';
            echo '<div class = "dropdown-menu">';
            $sql2 = "SELECT Event_Name AS Name, PageLink AS Link from event";
            $result2 = $conn->query($sql2);
            $c3 = 'Name';
            $c4 = 'Link';
            while ($row = $result2->fetch_assoc()) {
                echo "<a class = 'dropdown-item' href = '$row[$c4]'>" . $row[$c3] . '</a>';
            }
            echo '</div>';
            echo '</li>';
            echo '</ul>';
            echo '<ul class = "nav navbar-nav ml-auto">';
            echo '<li class = "nav-item">';
            echo '<a class = "nav-link" href = "signup.php"><span class = "fas fa-user"></span> Sign Up</a>';
            echo '</li>';
            echo '<li class = "nav-item">';
            echo '<a class = "nav-link" href = "login.php"><span class = "fas fa-sign-in-alt"></span> Login</a>';
            echo '</li>';
        }
        ?>
    </ul>

</div>
</div>
</nav>
</body>
</html>
