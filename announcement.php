
<html>
    <head>
        <meta charset="UTF-8">
        <title>Announcement</title>
        <link rel="stylesheet" href="announcement.css">
    </head>
    <body>
        <?php
        include 'header.php';
        ?>
        <?php
        if (isset($_SESSION['AdminEmail'])) {
            include 'logout.php';
            header("Location: login.php");
        } else if (isset($_SESSION['MemberEmail'])) {
            
        } else {
            header("Location: login.php");
        }
        ?>
        <div class="content">
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
                    . "<tr><th><a href='$self?sc=$c0' class='sorting'>$c0</a></th>"
                    . "<th><a href='$self?sc=$c1' class='sorting'>$c1</a></th>"
                    . "<th><a href='$self?sc=$c2' class='sorting'>$c2</a></th>"
                    . "<th><a href='$self?sc=$c3' class='sorting'>$c3</a></th>"
                    . "<th><a href='$self?sc=$c4' class='sorting'>$c4</a></th>"
                    . "<th></th></tr>";
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr><td>$row[$c0]</td><td>$row[$c1]</td><td>$row[$c2]</td><td>$row[$c3]</td><td>$row[$c4]  $p</td>"
                        . "<td><a href='viewannouncement.php?num=$row[$c0]' class='btn btn-info'>View</a></tr> ";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>

            <h1 style="text-align: center;">Announcement</h1>
        </div>

    </body>
</html>
