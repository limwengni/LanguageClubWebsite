<?php
$page_titles = "Profile";
include 'helper.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <?php echo "<title>$page_titles</title>" ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="profile.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    </head>
    <body>
        <?php
        include 'header.php';
        ?>
        <div class ="content">               
            
            <div class ="memberInfo">
                
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['MemberEmail'])) {
                    
                } else {
                    header("Location: login.php");
                }

                $email = $_SESSION['MemberEmail'];
                $sql = "SELECT memberID AS ID, memberName AS Name, memberIC AS IC, memberEmail AS Email, memberMobile AS MobilePhone, memberGender AS Gender, dateofbirth AS DOB, languageClass AS Class, ProfilePicture AS PFP from Member WHERE memberEmail = '$email'";
                $result = $conn->query($sql);

                $c1 = 'Name';
                $c2 = 'IC';
                $c3 = 'Email';
                $c4 = 'MobilePhone';
                $c5 = 'Gender';
                $c6 = 'DOB';
                $c7 = 'Class';
                $c8 = 'ID';
                $c9 = "PFP";

                if ($result->num_rows > 0) {
                    echo'<table class ="table table-hover" id ="memberInfo">';
                    while ($col = $result->fetch_assoc()) {
                        
                        echo "<a href = 'image.php?id=$col[$c8]'>";
                        ?>
                            <img src ="data:image/;base64,<?php echo base64_encode($col[$c9]); ?>" width = '200' height = '200' style = 'border-radius:50%; text-align: center;' /></a><br><br>
                            <?php
                            echo "<tr><h4 style = 'float:left;'>Personal Information <a href='edit.php?id=$col[$c8]'><i class = 'fas fa-edit' id = 'edit'></i><div class = 'sDivider'></div></h4></tr>";
                            echo "<tr><th>$c8</th><td>$col[$c8]</td></tr>";
                            echo "<tr><th>$c1</th><td>$col[$c1]</td></tr>";
                            echo "<tr><th>$c2</th><td>$col[$c2]</td></tr>";
                            echo "<tr><th>$c3</th><td>$col[$c3]</td></tr>";
                            echo "<tr><th>Mobile Phone</th><td>$col[$c4]</td></tr>";
                            $gender = getGender($col[$c5]);
                            $genderIcon = getGenderIcon($col[$c5]);
                            echo "<tr><th>$c5</th><td>$gender <i class = '$genderIcon'></i></td></tr>";
                            echo "<tr><th>Date Of Birth</th><td>$col[$c6]</td></tr>";
                            echo "<tr><th>Language Class</th><td>$col[$c7]</td></tr>";
                        }
                    }
                    echo '</table>';
                    ?>
            </div>
        </div>
    </body>
</html>

                     <!--                        <tr>
                     <th>Name</th>
                     <td>Lim Weng Ni <a href="update.php"></a></td>
                </tr>
                <tr>
                    <th>IC</th>
                    <td>031227-09-0058</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>limwn-wm21@student.tarc.edu.my</td>
                </tr>
                <tr>
                    <th>Mobile Phone</th>
                    <td>0123456789</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>Female</td>
                </tr>
                <tr>
                    <th>Class Joined</th>
                    <td>None</td>
                </tr>-->