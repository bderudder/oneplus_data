<?php include_once 'fragment/leaderboard_top.php' ?><!-- I needed to force other css for wrapper somehow here -->

<div class="wrapper-vertical-centered">
    <div class="containerleader">
        <section class="middle">
            <article class="bodyleaderboard">
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
                    $itemPerPage = 10; //Items per page
                    $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1; //Current page number
                    $fromIndex = ($page - 1) * $itemPerPage;
                    $toIndex = (($page * $itemPerPage) > count($users)) ? (count($users) - 1) : ($page * $itemPerPage);

                    //Pagination variables
                    $maxPageCountShown = 15; //Odd number only !!
                    $firstPageButtonNumber = ($page - (($maxPageCountShown - 1) / 2)) < 1 ? 1 : ($page - (($maxPageCountShown - 1) / 2));
                    $lastPageButtonNumber = (($page + (($maxPageCountShown - 1) / 2)) * $itemPerPage) > count($users) ? ceil(count($users) / $itemPerPage) : ($page + (($maxPageCountShown - 1) / 2));
                    $prevPage = ($page - 1) < 1 ? 1 : ($page - 1);
                    $nextPage = (($page + 1) * $itemPerPage) > count($users) ? $page : ($page + 1);
                    ?>
                    <?php for ($i = $fromIndex; $i < $toIndex; $i++) { ?>
                        <tr>
                            <td><?php echo $i + 1 ?></td>
                            <td><?php echo $users[$i]['username'] ?></td>
                            <td><?php echo beautifyNumber($users[$i]['rank']) ?></td>
                            <td><?php echo beautifyNumber($users[$i]['referrals']) ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <ul class="pagination">
                    <li class="pagination-prev"><a href="?page=<?php echo $prevPage ?>">Previous</a></li>
                    <?php for ($i = $firstPageButtonNumber; $i <= $lastPageButtonNumber; $i++) { ?>
                        <li <?php if ($i == $page) echo 'id="active"' ?>><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php } ?>
                    <li class="pagination-next"><a href="?page=<?php echo $nextPage ?>">Next</a></li>
                </ul>
            </article>


            <div class="clear"></div>

        </section>


    </div>
</div>

<?php include_once 'fragment/template_bottom.php' ?>
