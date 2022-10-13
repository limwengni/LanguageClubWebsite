<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="event.css" />

        <title>Event</title>
    </head>
    <body>
        <?php
        include 'header.php';
        ?>
        <div class="content">
            <div class ="picDisplay">
                <div class="container">
                    <div class="column">
                        <img src="Japan.jpg" alt="Avatar" class="image" >
                    </div>
                    <div class="overlay">
                        <p class="text-title">Japan Language Class</p>
                        <form method="POST" action="booking.php">
                        <a href="booking.php?LanguageClass=Japanese" target="_blank">
                            <input type="hidden" class="button" name="LanguageClass" value="Japanese"><span class="button">Join Now! </span>
         
                        </a>
                            </form>
                        <br>
                        <a href="japanese-event-info.php" target="_blank">
                            <button class="button" style="vertical-align:middle"><span>More Info </span></button>
                        </a>
                    </div>
                </div>
                <div class="container">
                    <div class="column">
                        <img src="French.jpg" alt="Avatar" class="image" >
                    </div>
                    <div class="overlay">
                        <p class="text-title">French Language Class</p>
                        <a href="booking.php?LanguageClass=French" target="_blank">
                            <input type="hidden" class="button" name="LanguageClass" value="French"><span class="button">Join Now! </span>
         
                        </a>
                        <br>
                        <a href="french-event-info.php" target="_blank">
                            <button class="button" style="vertical-align:middle"><span>More Info </span></button>
                        </a>
                    </div>
                </div>
                <div class="container">
                    <div class="column">
                        <img src="Spain.jpg" alt="Avatar" class="image">
                    </div>
                    <div class="overlay">
                        <p class="text-title">Spanish Language Class</p>
                       <a href="booking.php?LanguageClass=Spanish" target="_blank">
                            <input type="hidden" class="button" name="LanguageClass" value="Spanish"><span class="button">Join Now! </span>
         
                        </a>
                        <br>
                        <a href="spanish-event-info.php" target="_blank">
                            <button class="button" style="vertical-align:middle"><span>More Info </span></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <?php
    include 'footer.php';
    ?>
</html>
