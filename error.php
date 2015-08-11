<?php

$email = $_GET['email'];
$user = $_GET['user'];

//$servername = "localhost:3307";
//$username = "root";
//$password = "usbw";
//$dbname = "oneplusinvites";

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "oneplusdata";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "SELECT rank, referrals FROM users WHERE `DisplayName` = ?";
$stmt = $conn->stmt_init();
$stmt->prepare($query);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $rank = $row[0];
    $referrals = $row[1];
}

$conn->close();

$users;

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT rank, referrals, displayname FROM users ORDER BY rank ASC LIMIT 5";

$count = 0;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        $users[$count]['username'] = $row["displayname"];
        $users[$count]['rank'] = $row["rank"];
        $users[$count]['referrals'] = $row["referrals"];
    }
} else {
    echo "0 results";
}

$sql = "SELECT COUNT(*) FROM `users`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_users = $row['COUNT(*)'];
    }
} else {
    echo "0 results";
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OnePlus Reservation Data</title>


    <link rel="stylesheet" href="css/style.css">


</head>

<body>

<section class="leaderboard">

    <!-- Display top 5 members (highest rank? Most referrals?) -->

    <header>
        <h1>Leader board</h1>
        <h4><a href="#">View leader board</a></h4>
    </header>

    <form>
        <div id="mainselection">
            <select name="sort">
                <option value="rank">Sort by rank</option>
                <!-- Sort leaderboard by Rank -->
                <option value="refs">Sort by referrals</option>
                <!-- Sort leaderboard by Referrals -->
            </select>
        </div>
    </form>

    <h2>100 members joined so far</h2>
    <ol>

        <!-- Get data from database here, username, rank and refs
        (it would be nice if you have the . in 1.000.000 it makes it more easy to read) -->

        <li id="one"><?php echo $users[1]['username']; ?><br/><span>Rank: <?php echo $users[1]['rank']; ?> / Referrals: <?php echo $users[1]['referrals'] ?></span></li>
        <li id="two"><?php if (isset($users[2])) {
                echo $users[2]['username'];
            } ?><br/><span>Rank: <?php if (isset($users[2])) {
                    echo $users[2]['rank'];
                } ?> / Referrals: <?php if (isset($users[2])) {
                    echo $users[2]['referrals'];
                } ?></span></li>
        <li id="three"><?php if (isset($users[3])) {
                echo $users[3]['username'];
            } ?><br/><span>Rank: <?php if (isset($users[3])) {
                    echo $users[3]['rank'];
                } ?> / Referrals: <?php if (isset($users[3])) {
                    echo $users[3]['referrals'];
                } ?></span></li>
        <li id="three"><?php if (isset($users[4])) {
                echo $users[4]['username'];
            } ?><br/><span>Rank: <?php if (isset($users[4])) {
                    echo $users[4]['rank'];
                } ?> / Referrals: <?php if (isset($users[4])) {
                    echo $users[4]['referrals'];
                } ?></span></li>
        <li id="three"><?php if (isset($users[5])) {
                echo $users[5]['username'];
            } ?><br/><span>Rank: <?php if (isset($users[5])) {
                    echo $users[5]['rank'];
                } ?> / Referrals: <?php if (isset($users[5])) {
                    echo $users[5]['referrals'];
                } ?></span></li>
    </ol>

</section>


<div class="wrapper">

    <div class="container">

        <!-- Do you handle the error messages? -->

        <section class="middle">
            <h1>Titel error/info</h1>

            <div class="clear"></div>

            <?php
            if (!empty($error)) {
                echo '<div class="error box">' . $error . '</div>';
            }
            if (!empty($info)) {
                echo '<div class="info box">' . $info . '</div>';
            }
            ?>


            <form action="index.php">
                <button class="btn btn-3 btn-3e icon-arrow-right" type="submit">Go back</button>
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
