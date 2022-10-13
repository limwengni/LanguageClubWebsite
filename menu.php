<?php
$page_title = "Menu";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $page_title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="menu.css">
    </head>
    <body>
        <?php
        include 'header.php';
        include 'helper.php';
        $sql = "SELECT Event_Name AS Name, Event_Desc AS Descp, Language_Name AS LanguageName, Picture AS Pic from event";
        $result = $conn->query($sql);

        $c1 = 'Name';
        $c2 = 'Descp';
        $c3 = 'LanguageName';
        $c4 = 'Pic';

        echo "<h1>Foreign Language Society</h1><br>";
        echo '<p style = "text-align: center;">We offers a variety of short language courses to students, such as: </p>';
        while ($row = $result->fetch_assoc()) {

            echo '<div class="classes">';
            ?>

            <img src="data:image/;base64,<?php echo base64_encode($row[$c4]); ?>" width="120" height="120" style="border-radius: 50%;">
            <?php echo "<h4 style = 'padding-top: 10px;'>".$row[$c1]."</h4>";
            echo "<p>".$row[$c2]."</p>";
            echo '</div>';
        }
        echo '</table>';
        ?>

        <!--    <h1>Foreign Language Society</h1><br>
            <p style="text-align: center;">We offers a variety of short language courses such as <b>French</b>, <b>Spanish</b> and <b>Japanese</b> to students.</p>
        
            <div class="classes">
                <img src="France.png" alt="France" width="120" height="120" style="border-radius: 50%;">
                <h4 style="padding-top: 10px;">French</h4>
                <p>French is currently the fourth most widely spoken language in the European Union French is also 
                    the third most widely understood language in the EU, after English and German.</p>
            </div>
            <div class="classes">
                <img src="Spain.png" alt="Spanish" width="120" height="120" style="border-radius: 50%;">
                <h4 style="padding-top: 10px;">Spanish</h4>
                <p>Spanish is a Romance language in the Ibero-Romance group and the second most natively spoken language in the world, after Mandarin Chinese, 
                    Spanish is also the second most studied language, after English.
            </div>
            <div class="classes">
                <img src="Japan.png" alt="Japanese" width="120" height="120" style="border-radius: 50%;">
                <h4 style="padding-top: 10px;">Japanese</h4>
                <p>Japanese is spoken natively by about 128 million people, primarily by Japanese people and primarily in Japan.</p>
            </div>-->

        <div class="moreInfo" style="padding-bottom: 10px; text-align: center;">
            <a href="event.php" id="explore" class="btn btn-info" style="padding: 10px 15px 10px 15px;">Explore Now</a>
        </div>

    </body>
    <?php
    include 'footer.php';
    ?>
</html>
