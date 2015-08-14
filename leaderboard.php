<?php include_once 'fragment/template_top.php' ?>

<div class="wrapper-vertical-centered">
    <div class="containerleader">
        <section class="middle">
            <h1>Reservation Data Leader Board</h1>

            <div class="clear"></div>
            <table id="leaderboard">
                <tr>
                    <th>Website rank</th>
                    <th>Display Name</th>
                    <th>Reservation Rank</th>
                    <!--
                        Sort by BEST/WORST when you click on it? Indicate with small arrow? up/down

                        Just in case you did not notice, sorting by rank or referrals is exactly the same.
                        The more referrals you have, the best is your rank :P Someone with the best rank is
                        necessary the one with the most referrals.

                        PS: Sorting is ready -> leaderboard.php?sort=0 (or 1)
                    -->
                    <th>Refferrals</th>
                </tr>
                <?php
                    $conn = connectDB();
                    $sort = (isset($_GET['sort']) ? $_GET['sort'] : 0);
                    $users = getAllUsers($conn, $sort);
                    $conn->close();
                    $itemPerPage = 35; //Items per page
                    $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1; //Current page number
                    $fromIndex = ($page - 1) * $itemPerPage;
                    $toIndex = (($page * $itemPerPage) > count($users)) ? (count($users)-1) : ($page * $itemPerPage);
                ?>
                <?php for($i = $fromIndex; $i < $toIndex; $i++) { ?>
                    <tr>
                        <td><?php echo $i + 1 ?></td>
                        <td><?php echo $users[$i]['username'] ?></td>
                        <td><?php echo beautifyNumber($users[$i]['rank']) ?></td>
                        <td><?php echo beautifyNumber($users[$i]['referrals']) ?></td>
                    </tr>
                <?php } ?>
            </table>
            <!-- Missing a pager with href=leaderboard.php?page=pageNumber -->

            <ul class="pagination">
                <li class="pagination-prev">Previous</li>
                <li class="pagination-active"><a href="?page=1">1</a></li>
                <li><a href="?page=2">2</a></li>
                <li><a href="?page=3">3</a></li>
                <li><a href="?page=4">4</a></li>
                <li><a href="?page=5">5</a></li>
                <li><a href="?page=6">6</a></li>
                <li><a href="?page=7">7</a></li>
                <li class="pagination-next"><a href="#">Next</a></li>
            </ul>


        </section>
    </div>
</div>

<?php include_once 'fragment/template_bottom.php' ?>
