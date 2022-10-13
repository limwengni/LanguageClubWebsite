<?php
//footer.php
$page_title = "Footer";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $page_title ?></title>
        <style>
            body{
                font-family: sans-serif;
            }

            .footer{
                background-color: #9891B0;
                left: 0;
                bottom: 0;
                width: 100%;
                padding: 10px;
                min-height: 40px;
            }

            .contact{
                color: white;
                font-size: 20px;
                padding-left: 20px;
                padding-top: 20px;
            }

            .contactContent{
                padding-left: 20px;
                padding-top: 20px;
                font-size: 15px;
                color: white;
            }

            .contactEmail{
                color: rgb(255, 255, 255);
            }

            .contactEmail:hover{
                color: rgba(255, 255, 255, 0.55);
            }

            .column{
                float:left;
                width: 33%;
                padding: 10px;
            }

            .footer:after {
                content: "";
                display: table;
                clear: both;
            }

            .qLinks{
                padding-left: 20px;
                padding-top: 20px;
                color: rgb(255, 255, 255);
                font-size: 15px;
                text-decoration: none;
            }

            .qLinks:hover{
                color: rgba(255, 255, 255, 0.55);
            }

            .sDivider{
                height: 3px;
                background-color: white;
                width: 100%;
                max-width: 40px;
            }

            .map{
                padding-left: 20px;
            }

            @media (max-width:1000px){
                .footer{
                    padding: 5px;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                }

                .column{
                    float:left;
                    width: 100%;
                }

            }
        </style>
    </head>
    <body>
        <div class="footer">
            <div class="column">
                <h4 class="contact">CONTACT US<div class="sDivider"></div></h4>
                <div class="contactContent">
                    <p><strong>CENTRE FOR FOREIGN LANGUAGES</strong></p>
                    <p>TUNKU ABDUL RAHMAN UNIVERSITY COLLEGE</p>
                    <p>JALAN GENTING KELANG SETAPAK 53300 KUALA LUMPUR</p><br>

                    <p class="telNEmail">TELEPHONE: +6012-345 6789 Ext no. 3233</p>
                    <p>EMAIL :<a href="mailto:tarc_event@edu.my" class="contactEmail" style="text-decoration:none;"> tarc_event@edu.my</a></p><br>

                    <p class="openHours">OPENING HOURS</p>
                    <p>8.30am - 5.30pm (Monday - Friday)</p>
                </div>
            </div>
            <div class="column">
                <h4 class="contact">LINKS<div class="sDivider"></div></h4><br>

                <div class="links">
                    <p><a class="qLinks" href="menu.php">Home</a></p><br>
                    <p><a class="qLinks" href="aboutus.php">About Us</a></p><br>
                    <p><a class="qLinks" href="event.php">Events</a></p><br>
                    <?php
                    if (isset($_SESSION['MemberEmail'])) {
                        echo '<p><a class = "qLinks" href = "profile.php"><span class = "fas fa-user"></span> Profile</a></p><br>';
                        echo '<p><a class = "qLinks" href = "announcement.php"><span class = "fas fa-bullhorn"></span> Announcement</a></p><br>';
                        echo '<p><a class = "qLinks" href = "logout.php"><span class = "fas fa-sign-out-alt"></span> Log Out</a></p>';
                    } else if (isset($_SESSION['AdminEmail'])) {
                        echo '<p><a class = "qLinks" href = "dashboard.php"><span class = "fas fa-user"></span> Dashboard</a></p><br>';
                        echo '<p><a class = "qLinks" href = "memberList.php"><span class = "fas fa-list"></span> Member List</a></p><br>';
                        echo '<p><a class = "qLinks" href = "logout.php"><span class = "fas fa-sign-out-alt"></span> Log Out</a></p>';
                    } else {
                        echo '<p><a class = "qLinks" href = "signup.php"><span class = "fas fa-user"></span> Sign Up</a></p><br>';
                        echo '<p><a class = "qLinks" href = "login.php"><span class = "fas fa-sign-in-alt"></span> Login</a></p>';
                    }
                    ?>
                </div>
            </div>
            <div class="column">
                <h4 class="contact">FIND US HERE<div class="sDivider"></div></h4><br>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7967.0749403429945!2d101.7273345238037!3d3.2153427610923666!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2dc5e067aae3ab84!2sTunku%20Abdul%20Rahman%20University%20College%20(TAR%20UC)!5e0!3m2!1sen!2sus!4v1660141690684!5m2!1sen!2sus" width="350" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
            </div>
        </div>
    </body>
</html>
