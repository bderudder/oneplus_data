<?php
include_once('functions.php');

//one.com hosting offers a timeout of 50 seconds and doesn't let override this setting.
$startTime = time();
$taskID = 0;

if (($conn = connectDB())) {
    if (isset($_GET['action']) && $_GET['action'] == 'getprogress') {
        $taskID = isTaskRunning($conn);
        if ($taskID != 0) {
            echo getTaskUserCountProgress($conn, $taskID) . '/' . getTaskTotalUserToUpdate($conn, $taskID);
        }
    } else {
        $users = getAllUsersWithoutSorting($conn);

        if((($taskID = isTaskRunning($conn)) != 0) && !(isset($_GET['action']) && $_GET['action'] == 'continue')) {
            //If there is a task running and the action!=continue,
            //we stop to avoid multiple task instance being ran at same time.
            exit();
        }

        if(($taskID = isTaskRunning($conn)) == 0) {
            //if no task is running, create a new one.
            $taskID = createTask($conn, count($users));
        }

        if ($taskID != 0) {
            for ($i = getTaskUserCountProgress($conn, $taskID); $i < count($users); $i++) {
                //If time elapsed is more than 15 seconds, rerun the script to bypass PHP timeout
                if((time() - $startTime) > 15) {
                    asyncExecuteScript('update_user_stats.php?action=continue');
                    exit('Script continuing on another process.');
                }
                updateTaskProgress($conn, $taskID, $users[$i]['id']);
                $newUserStats = fetchUserStatsFromKid($users[$i]['invite_url']);
                updateUserStats($conn, $users[$i]['username'], explode(';', $newUserStats)[0], explode(';', $newUserStats)[1]);
            }
            setTaskFinished($conn, $taskID, -1);
            exit('Update finished.');
        } else {
            exit('error : Couldn\'t create task in database.');
        }
    }
} else {
    exit('error : Couldn\'t connect to database.');
}

/**
 * The reason why we don't want sorting is because the script calls itself after having updated a few
 * users. This can change the index order.
 *
 * @param $conn
 * @return array
 */
function getAllUsersWithoutSorting($conn) {
    $users = array();
    $result = $conn->query('SELECT * FROM users');

    $count = 0;
    while($row = $result->fetch_assoc()) {
        $users[$count]['id'] = $row['id'];
        $users[$count]['invite_url'] = $row['invite_url'];
        $users[$count]['username'] = $row['displayname'];
        $count++;
    }
    return $users;
}

/**
 * If no task is running, it returns 0, otherwise taskID
 */
function isTaskRunning($conn)
{
    $result = $conn->query("SELECT if(ISNULL(ended), id, 0) AS task_running_id FROM users_update_task where id = (SELECT max(id) FROM users_update_task)");
    $row = $result->fetch_assoc();

    return $row['task_running_id'];
}

function createTask($conn, $totalUserCount)
{
    $conn->query("INSERT INTO users_update_task(started, total_user_count, user_updated_count) VALUES(now(), {$totalUserCount}, 0)");
    $taskID = $conn->insert_id;

    return $taskID;

}

function updateTaskProgress($conn, $taskID, $userID)
{
    $query = 'UPDATE users_update_task SET current_user_id=?, user_updated_count=user_updated_count+1 WHERE id=?';
    $stmt = $conn->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("ii", $userID, $taskID);
    $stmt->execute();
}

function setTaskFinished($conn, $taskID, $userID)
{
    $query = 'UPDATE users_update_task SET current_user_id=?, ended=now() WHERE id=?';
    $stmt = $conn->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("ii", $userID, $taskID);
    $stmt->execute();
}

function updateUserStats($conn, $username, $rank, $referrals)
{
    $query = 'UPDATE users SET rank=?, referrals=? WHERE displayname=?';
    $stmt = $conn->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("iis", $rank, $referrals, $username);
    $stmt->execute();
}

/**
 * Get the number of users to be refreshed
 */
function getTaskTotalUserToUpdate($conn, $taskID)
{
    $result = $conn->query("SELECT total_user_count FROM users_update_task WHERE id={$taskID}");
    return $result->fetch_assoc()['total_user_count'];
}

/**
 * Get the users refreshed count on this task
 */
function getTaskUserCountProgress($conn, $taskID)
{
    $result = $conn->query("SELECT user_updated_count FROM users_update_task WHERE id={$taskID}");
    return $result->fetch_assoc()['user_updated_count'];
}

/**
 * Run a PHP script and stop waiting after 2000ms.
 * @param $filename PHP file to execute
 */
function asyncExecuteScript($filename) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, getWebsiteRoot().'/'.$filename);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);

    curl_exec($ch);
    curl_close($ch);
}