<?php
$page_title = "About Us";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $page_title ?></title>
        <link rel="stylesheet" href="aboutus.css">
    </head>
    <body>
        <?php
        include 'header.php';
        ?>

        <div class="content">
            <h1>About Us</h1><br>
            <p style="text-align: center;">Why we create Language and Communication Society?</p>

            <p>First of all, this society is created so that students can take this opportunity to learn more foreign languages.
                By learning these languages, students can study abroad in the countries that they desired.
                Currently, we have a lot of language classes available for students to join. These classes will be facilitated by experience and qualified instructors.
                Fun-filled activities are embedded in class to enrich students' learning experience and exposure in understand the languages and their cultures.</p>
            <p>For more info, click <a href ="event.php" id="exploreMore">here</a> to explore.</p>

            <img src="study.jpg" alt="student" class="student" style='padding-bottom: 10px;'>

        </div>
    </body>
    <?php
    include 'footer.php';
    ?>
</body>
</html>
