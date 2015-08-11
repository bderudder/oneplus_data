<?php

include_once("functions.php");


$user;

$conn = connectDB();
if (!isset($conn)) {
    exit('Failed to connect to database.');
}

$sort = (isset($_GET['sort']) ? $_GET['sort'] : 0);

$users = showFirstFive($conn, $sort);

$conn->close();

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
    <link rel="stylesheet" href="css/mediascreen.css">
    <script language="javascript" type="text/javascript">
        function doReload(catid) {
            document.location = 'index.php?sort=' + sort;
        }
    </script>
</head>

<body>


<div class="wrapper">
    <div class="wrapper-vertical-centered">
        <section class="leaderboard">
            <header>
                <h1>Leader board</h1>
                <h4><a href="#">View leader board</a></h4>
            </header>

            <form action="index.php" method="get">
                <div id="mainselection">
                    <select name="sort" onchange="this.form.submit();">
                        <!-- Sort leaderboard by Rank -->
                        <option <?php if ($sort == 0) print 'SELECTED'; ?> value="0">Sort by best rank</option>
                        <!-- Sort leaderboard by Referrals -->
                        <option <?php if ($sort == 1) print 'SELECTED'; ?> value="1">Sort by worst rank</option>
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

        <div class="container">
            <?php if (!isset($_GET['invite_url']) || ($apiInfo = fetchUserStatsFromKid($_GET['invite_url'])) == null) { ?>
                <section class="middle">
                    <h1>Welcome OnePlus Fan</h1>

                    <h3>Get your reservation data by filling in your (forum)name & email below.</h3>

                    <div class="clear"></div>

                    <?php if (isset($_GET['invite_url'])) { ?>
                        <h2>Invalid referral invite link. Please try again.</h2>
                    <?php } ?>

                    <form class="form" method="get" action="index.php">
                        <input type="text" name="disname" placeholder="Display name" value="<?php echo $prevUsername ?>" required>
                        <input type="email" name="email" placeholder="Enter a valid email address" value="<?php echo $prevEmail ?>" required>
                        <input type="text" name="invite_url" placeholder="Enter your referral invite link" required>
                        <button class="btn btn-3 btn-3e icon-arrow-right" type="submit">Show data</button>
                    </form>
                </section>
            <?php } else { ?>
                <?php addNewUserInDB($_GET['disname'], $_GET['email'], $_GET['invite_url']); ?>
                <section class="middle">
                    <h1>We found your data!</h1>

                    <div class="clear"></div>
                    <table>
                        <tr>
                            <td><h2>Reservation rank</h2></td>
                            <td><h2>Number of referrals</h2></td>
                        </tr>
                        <tr>
                            <td><h1><?php echo explode(';', $apiInfo)[0] ?></h1></td>
                            <td><h1><?php echo explode(';', $apiInfo)[1] ?></h1></td>
                        </tr>
                    </table>

                    <form action="index.php">
                        <button class="btn btn-3 btn-3e icon-arrow-right" type="submit">Go back</button>
                    </form>
                </section>
            <?php } ?>
        </div>

    </div>
        <footer>
            <p>Made with love by
                <a href="http://www.bdmultimedia.be/" target="_blank">BDmultimedia</a>,
                <a href="https://forums.oneplus.net/members/xtrme-q.155318/" target="_blank">Xtrme Q</a> &
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
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</html>
