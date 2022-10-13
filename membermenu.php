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
        include 'loginheader.php';
        ?>

        <h1>Foreign Language Society</h1><br>
        <p style="text-align: center;">We offers a variety of short language courses such as <b>French</b>, <b>Spanish</b> and <b>Japanese</b> to students.</p>

        <div class="French">
            <img src="France.png" alt="France" width="120" height="120" style="border-radius: 50%;">
            <h4 style="padding-top: 10px;">French</h4>
            <p>French is currently the fourth most widely spoken language in the European Union French is also 
                the third most widely understood language in the EU, after English and German.</p>
        </div>
        <div class="Spanish">
            <img src="Spain.png" alt="Spanish" width="120" height="120" style="border-radius: 50%;">
            <h4 style="padding-top: 10px;">Spanish</h4>
            <p>Spanish is a Romance language in the Ibero-Romance group and the second most natively spoken language in the world, after Mandarin Chinese, 
                Spanish is also the second most studied language, after English.
        </div>
        <div class="Japanese">
            <img src="Japan.png" alt="Japanese" width="120" height="120" style="border-radius: 50%;">
            <h4 style="padding-top: 10px;">Japanese</h4>
            <p>Japanese is spoken natively by about 128 million people, primarily by Japanese people and primarily in Japan.</p>
        </div>

        <div class="moreInfo" style="padding-bottom: 10px; text-align: center;">
            <a href="event.php" id="explore" class="btn btn-info" style="padding: 10px 15px 10px 15px;">Explore Now</a>
        </div>

    </body>
    <?php
    include 'loginfooter.php';
    ?>
</html>
