<?php

include_once("functions.php");

//Used to fill textbox automatically when wrong invite url has been given
$prevUsername = (isset($_GET['disname']) ? $_GET['disname'] : '');
$prevEmail = (isset($_GET['email']) ? $_GET['email'] : '');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OnePlus Reservation Data</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/mediascreen.css">
    <link rel="stylesheet" href="css/ladda.min.css">
    <!-- ladda is required for loading buttons -->
    <script language="javascript" type="text/javascript">
        function doReload(catid) {
            document.location = 'index.php?sort=' + sort;
        }
    </script>
    <script src="js/modernizr.custom.js"></script>
</head>

<body>


<div class="wrapper">
    <div class="wrapper-vertical-centered">

        <p><button id="trigger-overlay" type="button">&#9776; Menu</button></p>


        <?php include_once 'fragment/top5leaderboard.php' ?>

        <div class="container">
            
                <section class="middle">
                    <h1>Disclaimer</h1>
                    <br/>
                    <h3>We are committed to keeping your e-mail address confidential. We do not sell, rent, or lease our subscription lists to third parties, and we will not provide your personal information to any third party individual, government agency, or company at any time unless compelled to do so by law. This project is a community initiative and it’s not directly connected to OnePlus.</h3>
                    <br/>
                    <h3>We will use your e-mail address solely to provide timely information about your reservation stats and to inform you if you win one of our future giveaways.</h3>
                    <div class="clear"></div>   
                </section>

        </div>

    </div>
        <footer>
            <p>Made with love by
                <a href="http://www.bdmultimedia.be/" target="_blank">BDmultimedia</a>,
                <a href="https://forums.oneplus.net/members/xtrme-q.155318/" target="_blank">Xtrme Q</a>,
                <a href="https://forums.oneplus.net/members/jamesst20.131753/" target="_blank">Jamesst20</a>
            </p>
        </footer>

    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<!-- open/close -->
        <div class="overlay overlay-contentpush">
            <button type="button" class="overlay-close">Close</button>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <!--<li><a href="leaderboard.php">Leader Board</a></li>-->
                    <li><a href="disclaimer.php">Disclaimer</a></li>
                </ul>
            </nav>
        </div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!-- Spin & ladda is required for loading buttons -->
<script src="js/spin.min.js"></script>
<script src="js/ladda.min.js"></script>
<script src="js/index.js"></script>
<!-- Classie & Menu are required for menu -->
<script src="js/classie.js"></script>
<script src="js/menu.js"></script>

</html>
