<?php
$page_title = "Dashboard";
include 'helper.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $page_title ?></title>   
        <link rel="stylesheet" href="dashboard.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".reserved").click(function () {
                    $(".gender").slideToggle();
                });
            });
        </script>
    </head>
    <body>
        <?php
        include 'header.php';
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
        <div class="container" style="background-color: #fff; border-radius: 5px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); width: 100%; margin: 5px auto;">
            <div class="content">
                <table>
                    <th><h4 style="text-align: left; padding-left: 5px;">Event</h4></th>
                    <tr>
                        <?php
                        $sql = "SELECT S.*, E.Picture, G.Num_Female, G.Num_Male from eventstat S, event E, event_participant_based_on_gender G where S.event_ID = E.event_ID AND G.event_ID = E.event_ID";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<td style = 'padding: 10px 5px';>";
                                echo "<div class='classes'>";
                                ?>
                            <img src ="data:image/;base64,<?php echo base64_encode($row['Picture']); ?>" width = '100' height = '100' class="image" style = 'border-radius:50%;' /><br><br>
                            <?php
                            echo "<p class='text' style='float:right; padding: 20px;'>";
                            echo "<strong><div style= 'font-size:50px;'>" . ($row['SeatReav'] / $row['MaxPersons'] * 100) . "%</div></strong> seats taken in " . "<strong>" . $row['Event_Name'] . "</strong></p><hr>";
                            echo "<p>" . "<strong><div class='reserved' style= 'font-size:30px;'>" . $row['SeatReav'] . "</div></strong> seat(s) reserved for " . $row['Event_Name'] . "</p>";
                            echo "<div class='gender'>" . "<div><i class='fa fa-female' aria-hidden='true'></i>" . " " . $row['Num_Female'] . " Female(s)</div>" . "<div><i class='fa fa-male' aria-hidden='true'></i>" . " " . $row['Num_Male'] . " Male(s)" . "</div></div>";
                            echo "<p>" . "<strong><div style= 'font-size:30px;'>" . $row['SeatsAvail'] . "</div></strong> seat(s) left for " . $row['Event_Name'] . "</p>";
                            echo "</td>";
                            echo "</div>";
                        }
                    } else {
                        echo "0 result";
                    }
                    ?>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
