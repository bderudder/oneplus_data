<?php

$conn = connectDB();
if (!isset($conn)) {
    exit('Failed to connect to database.');
}

$sort = (isset($_GET['sort']) ? $_GET['sort'] : 0);

$users = showFirstFive($conn, $sort);

$conn->close();
?>

<section class="leaderboard">
    <header>
        <h1>Leader board</h1>
        <h4><a href="leaderboard.php">View leader board</a></h4>
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
        <?php for ($i = 0; $i < 5; $i++) {
            if (isset($users[$i])) { ?>
                <li id="leaderboard-<?php echo $i+1 ?>">
                    <?php echo $users[$i]['username'] ?>
                    <br/>
                    <span>Rank: <?php echo beautifyNumber($users[$i]['rank']) ?> / Referrals: <?php echo beautifyNumber($users[$i]['referrals']) ?></span>
                </li>
            <?php }
        } ?>
    </ol>
</section>
