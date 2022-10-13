
<html>
    <head>
        <meta charset="UTF-8">
        <title>Member List</title>
        <link rel="stylesheet" href="memberList.css">
        <?php
        include "helper.php";
        include "header.php";
        $page_title = "Member List";
        ?>
    </head>
    <body>
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
        <div class="content">
            <h3><?php echo $page_title ?></h3>

            <div>
                <?php echo "<a href = 'memberList.php' class = 'btn btn-info' style = 'width: 120px'>Show All</a>"; ?>
            </div><br>

            <?php
//        $sql = "SELECT memberID AS ID, memberName AS Name, memberIC AS IC, memberEmail AS Email, memberMobile AS MobilePhone, memberPwd AS Password, memberGender AS Gender, dateofBirth as DOB, languageClass as class from Member";
//        $result = $conn->query($sql);
//
            $c0 = 'ID';
            $c1 = 'Name';
            $c2 = 'IC';
            $c3 = 'Email';
            $c4 = 'MobilePhone';
            $c5 = 'Password';
            $c6 = 'Gender';
            $c7 = 'DOB';
            $c8 = 'class';

            $search = $_GET['search'] ?? '';
            $column = $_GET['column'] ?? '';

            if ($column == 'memberID') {
                $sql2 = "SELECT memberID AS ID, memberName AS Name, memberIC AS IC, memberEmail AS Email, memberMobile AS MobilePhone, memberPwd AS Password, memberGender AS Gender, dateofBirth as DOB, languageClass as class from Member WHERE $column = ?";
            } else {
                $sql2 = "SELECT memberID AS ID, memberName AS Name, memberIC AS IC, memberEmail AS Email, memberMobile AS MobilePhone, memberPwd AS Password, memberGender AS Gender, dateofBirth as DOB, languageClass as class from Member WHERE $column like '%$search%'";
            }

            $stmt = $conn->prepare($sql2);
            if ($column == 'memberID') {
                $stmt->bind_param('i', $search);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <!--            <form action = "search.php" method = "get">
                            <div class = "input-group mb-3" style = "width: 40%;">
                                <input type = "text" name = "query" class = "form-control" placeholder = "Search using name" aria-describedby = "button-addon2">
                                <button class = "btn btn-info" type = "submit" value = "Search" id = "button-addon2" style = "z-index: 0;">Search</button>
                            </div>
                        </form>-->

            <?php
            if ($result->num_rows > 0) {
                echo "<table class = 'table table-hover' id='students'>"
                . "<tr>"
                . "<th style='width:3%'>$c0</a></th>"
                . "<th style='width:10%'>$c1</a></th>"
                . "<th>$c2</th>"
                . "<th colspan='2'>$c3</th>"
                . "<th style='width:10%'>Mobile Phone</th>"
                . "<th>$c5</th>"
                . "<th style='width:7%'>$c6</a></th>"
                . "<th style='width:9%'>Date Of Birth</th>"
                . "<th>Language Classes</th>"
                . "<th colspan='2' style='width:10%'>Changes</th>"
                . "</tr>";
                while ($row = $result->fetch_assoc()) {
                    $g = getGender($row[$c6]); //get full name of gender
                    echo "<tr><td>$row[$c0]</td><td>$row[$c1]</td><td>$row[$c2]</td><td colspan='2'>$row[$c3]</td><td>$row[$c4]</td><td>$row[$c5]</td><td>$g</td><td>$row[$c7]</td><td>$row[$c8]</td><td><a href='update.php?guest={$row['ID']}' id='edit'><i class = 'fas fa-edit'></i></a></td><td><a href='delete.php?guest={$row['ID']}' id='delete'><i class = 'fas fa-trash'></i></a></td>";
                }
                echo "<tr><td colspan=12>$result->num_rows record(s) returned.";
            } else {
                echo "0 result";
            }

            echo "</tr>";
            echo "</table>";
            ?>
        </div>
    </body>
</html>
