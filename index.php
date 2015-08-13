<?php include_once 'fragment/template_top.php' ?>

<?php
//Used to fill textbox automatically when wrong invite url has been given
$prevUsername = (isset($_GET['disname']) ? $_GET['disname'] : '');
$prevEmail = (isset($_GET['email']) ? $_GET['email'] : '');
?>

<div class="wrapper-vertical-centered">

    <?php include_once 'fragment/top5leaderboard.php' ?>

    <div class="container">
        <?php if (!isset($_GET['invite_url']) || ($apiInfo = fetchUserStatsFromKid($_GET['invite_url'])) == null) { ?>
            <section class="middle">
                <h1>Welcome OnePlus Fan</h1>
                <br/>

                <h3>Get your reservation data by filling in your (forum)name, email & kid below.</h3>

                <h3>We use your email for future giveaways.</h3>

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
                        <td><h1><?php echo beautifyNumber(explode(';', $apiInfo)[0]) ?></h1></td>
                        <td><h1><?php echo beautifyNumber(explode(';', $apiInfo)[1]) ?></h1></td>
                    </tr>
                </table>

                <form action="index.php">
                    <button class="btn btn-3 btn-3e icon-arrow-right" type="submit">Go back</button>
                </form>
            </section>
        <?php } ?>

        <div class="refresh-users-rank">
            <button class="ladda-button btn btn-3 btn-3e icon-arrow-right" data-style="expand-right"><span class="ladda-label">Refresh All Data</span></button>
        </div>
    </div>
</div>

<?php include_once('fragment/template_bottom.php') ?>
