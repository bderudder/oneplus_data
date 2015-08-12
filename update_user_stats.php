<?php
include_once('functions.php');

if (set_time_limit(0)) {
    if (($conn = connectDB())) {
        if(($taskID = isTaskRunning($conn)) != 0 || (isset($_GET['action']) && $_GET['action'] == 'getprogress')) {
            if($taskID != 0) {
                echo getTaskUserCountProgress($conn, $taskID).'/'.getTaskTotalUserToUpdate($conn, $taskID);
            }
        } else {
            echo 'Update started...';
            $users = getAllUsers($conn, 0);
            $taskID = createTask($conn, count($users));
            if($taskID != 0) {
                for($i = 0; $i < count($users); $i++) {
                    updateTaskProgress($conn, $taskID, $users[$i]['id']);
                    $newUserStats = fetchUserStatsFromKid($users[$i]['invite_url']);
                    updateUserStats($conn, $users[$i]['username'], explode(';', $newUserStats)[0], explode(';', $newUserStats)[1]);
                }
                setTaskFinished($conn, $taskID, -1);
                echo 'Update finished.';
            } else {
                exit('error : Couldn\'t create task in database.');
            }
        }
    } else {
        exit('error : Couldn\'t connect to database.');
    }

} else {
    exit("error : Couldn't remove the timeout limit. Aborting.");
}

function isTaskRunning($conn) {
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

function getTaskTotalUserToUpdate($conn, $taskID) {
    $result = $conn->query("SELECT total_user_count FROM users_update_task WHERE id={$taskID}");
    return $result->fetch_assoc()['total_user_count'];
}

function getTaskUserCountProgress($conn, $taskID) {
    $result = $conn->query("SELECT user_updated_count FROM users_update_task WHERE id={$taskID}");
    return $result->fetch_assoc()['user_updated_count'];
}