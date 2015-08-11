<?php

include_once("functions.php");


$user;
// Create connection //
$conn = connectDB();
// End creation //

// Check connection

echo checkConnection($conn);

// End Check //

//create the first five user arrays

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 0;
}

$users = showFirstFive($conn, $sort);

//end creating array//

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OnePlus Reservation Data</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mediascreen.css">
    <script language="javascript" type="text/javascript">
        function doReload(catid) {
            document.location = 'index.php?sort=' + sort;
        }
    </script>
</head>

<body>

<section class="leaderboard">

    <!-- Display top 5 members (highest rank? Most referrals?) -->

    <header>
        <h1>Leader board</h1>
        <h4><a href="#">View leader board</a></h4>
    </header>

    <form action="index.php" method="get">
        <div id="mainselection">
            <select name="sort" onchange="this.form.submit();">
                <!-- Sort leaderboard by Rank -->
                <option <?php if ($sort == 0) print 'SELECTED'; ?> value="0">Sort by rank</option>
                <!-- Sort leaderboard by Referrals -->
                <option <?php if ($sort == 1) print 'SELECTED'; ?> value="1">Sort by referrals</option>
            </select>
        </div>
    </form>

    <h2><?php $conn = connectDB();
        echo totalUsersRegistered($conn);
        $conn->close() ?> members joined so far</h2> <!-- Get the number of users that we have -->
    <ol>
        <!-- Get data from database here, username, rank and refs
        (it would be nice if you have the . in 1.000.000 it makes it more easy to read) -->
        <?php for ($i = 1; $i <= 5; $i++) {
            if (isset($users[$i])) { ?>
                <li id="leaderboard-<?php echo $i ?>">
                    <?php echo $users[$i]['username'] ?>
                    <br/>
                    <span>Rank: <?php echo $users[$i]['rank']; ?> / Referrals: <?php echo $users[$i]['referrals']; ?></span>
                </li>
            <?php }
        } ?>
    </ol>

</section>


<div class="wrapper">

    <div class="container">

        <section class="middle">
            <h1>Welcome OnePlus Fan</h1>

            <h3>Get your reservation data by filling in your (forum)name & email below.</h3>

            <div class="clear"></div>

            <form class="form" method="post" action="testsignup.php"> <!-- Do your thing? xD // efkes aangepast... getemail <-> testsignup (Bjorn) -->
                <input type="text" name="disname" required placeholder="Display name">
                <input type="email" name="email" required placeholder="Enter a valid email address">
                <button class="btn btn-3 btn-3e icon-arrow-right" type="submit">Show data</button>

                <!-- Show detail data here on same page, see detail.html -->

            </form>
        </section>

        <footer><p>Made with love by <a href="http://www.bdmultimedia.be/" target="_blank">BDmultimedia</a>, <a href="https://forums.oneplus.net/members/xtrme-q.155318/" target="_blank">Xtrme Q</a> &
                <a href="https://forums.oneplus.net/members/vici0us.663229/" target="_blank">Vici0us</a></p></footer>

    </div>

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
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>


</body>
</html>
