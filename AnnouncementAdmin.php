<!DOCTYPE html>
<!--Announcement Admin-->
<html>
    <head>
        <?php
        include "helper.php";
        $page_title = "Admin Announcement";
        echo "<title>".$page_title."</title>";
        include 'header.php';
        ?>
        <meta charset="UTF-8">
        <title>Edit Announcement</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="announcementadmin.css">

    </head>

    <body>
        <?php
        if (isset($_SESSION['AdminEmail'])) {
            
        } else if (isset($_SESSION['MemberEmail'])) {
            include 'logout.php';
            header("Location: login.php");
        } else {
            header("Location: login.php");
        }
        ?>
        <h1 style="text-align: center; margin-top: 50px;">Announcement</h1>

        <div class="container">
            <?php
            $p = $_GET['p'] ?? '';
            $filter = $p ? "WHERE Date = '$p'" : '';
            $orderby = $_GET['sc'] ?? 'Num';
            $sort = $_GET['sort'] ?? 'ASC';

            $sql = "SELECT Num, Club, Title, Sender, Date FROM announcement $filter ORDER BY $orderby $sort";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $c0 = 'Num';
            $c1 = 'Club';
            $c2 = 'Title';
            $c3 = 'Sender';
            $c4 = 'Date';
            $self = $_SERVER['PHP_SELF'];
            ?>

            <?php
            if ($result->num_rows > 0) {
                echo "<table class='table table-hover'>"
                . "<tr><th><a href='$self?sc=$c0'>$c0</a></th>"
                . "<th><a href='$self?sc=$c1'>$c1</a></th>"
                . "<th><a href='$self?sc=$c2'>$c2</a></th>"
                . "<th><a href='$self?sc=$c3'>$c3</a></th>"
                . "<th><a href='$self?sc=$c4'>$c4</a></th>"
                . "<th></th></tr>";
                while ($row = $result->fetch_assoc()) {

                    echo "<tr><td>$row[$c0]</td><td>$row[$c1]</td><td>$row[$c2]</td><td>$row[$c3]</td><td>$row[$c4]  $p</td>"
                    . "<td><a href='editAnnouncement.php?num=$row[$c0]' class='btn btn-warning'>Edit</a> "
                    . "<a href='deleteAnnouncement.php?num=$row[$c0]' class='btn btn-danger'>Delete</a></tr>";
                }
                echo "<tr><td colspan=5>$result->num_rows record(s) returned.</td> "
                . "<td><a href='insertAnnouncement.php' class='btn btn-primary'>Insert Announcement</a></td></tr>";
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>

    </body>

</html>
