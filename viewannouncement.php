<?php
$page_titles = "View Announcement";
include 'helper.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <?php echo "<title>$page_titles</title>" ?>
        <link rel="stylesheet" href="announcement.css">
        <script>
            function back() {
                window.location.href = "announcement.php"; //go back to announcement page
            }
        </script>
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
            <i class="fa fa-times fa-2x" id="close" style="float: right;" onClick="back()"/></i>
        <?php
        $num = $_GET['num'] ?? '';
        $sql = "SELECT Club, Title, Sender, Date, Content FROM announcement WHERE Num=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $num);
        $stmt->execute();
        $result = $stmt->get_result();
        $c0 = 'Club';
        $c1 = 'Title';
        $c2 = 'Sender';
        $c3 = 'Date';
        $c4 = 'Content';
        $c5 = 'Picture';

        if ($result->num_rows > 0) {
            echo'<table class ="table table-hover">';
            while ($col = $result->fetch_assoc()) {
                ?>
                <h1 style="text-align: center;"><?= $col[$c1] ?></h1>
                <?php
                echo "<tr><th>$c0</th><td>$col[$c0]</td></tr>";
                echo "<tr><th>$c2</th><td>$col[$c2]</td></tr>";
                echo "<tr><th>$c3<td>$col[$c3]</td></tr>";
                echo "<tr><th>$c4</th><td>$col[$c4]</td></tr>";
            }
        }
        echo '</table>';
        ?>
</div>
</body>
</html>
