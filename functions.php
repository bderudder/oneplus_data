<?php
/**
 * Connect to the database.
 * @return null if failed, otherwise mysqli.
 */
function connectDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "oneplus_data";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return null;
    }

    return $conn;
}

//--------------------------

/**
 * Fetch all users in database and stats cached in db
 * @return array of users
 */
function getAllUsers($connection, $sort)
{

    $userArray = array();

    $result = $connection->query('SELECT id, displayname, email, referrals, rank, invite_url FROM users ORDER BY rank '.($sort == 1 ? 'DESC' : 'ASC'));

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $userArray[$count]['id'] = $row["id"];
        $userArray[$count]['username'] = $row["displayname"];
        $userArray[$count]['rank'] = $row["rank"];
        $userArray[$count]['email'] = $row["email"];
        $userArray[$count]['referrals'] = $row["referrals"];
        $userArray[$count]['invite_url'] = $row["invite_url"];

        $count++;
    }

    return $userArray;
}


/**
 * Fetch users in database and stats cached in db
 * @return array of the first 5 users
 */
function showFirstFive($connection, $sort)
{

    $userArray = array();

    $result = $connection->query('SELECT displayname, referrals, rank FROM users ORDER BY rank '.($sort == 1 ? 'DESC' : 'ASC'));

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $userArray[$count]['username'] = $row["displayname"];
        $userArray[$count]['rank'] = $row["rank"];
        $userArray[$count]['referrals'] = $row["referrals"];

        if($count == 5) break;

        $count++;
    }

    return $userArray;
}


/**
 * Return the total of users that have registered on the website
 */
function totalUsersRegistered($connection)
{
    $sql = "SELECT COUNT(*) FROM users";

    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $total_users = $row['COUNT(*)'];
    }
    return $total_users;
}

/**
 * Check if a user is already registered
 */
function checkIfUserExists($connection, $user)
{
    $query = 'SELECT count(*) FROM users WHERE displayname = ?';
    $stmt = $connection->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_array(MYSQLI_NUM)[0] > 0;
}

/**
 * Get a single existing user stats cached in database
 */
function getUserStatsFromDB($connection, $user)
{
    $userArray = array();

    $query = "SELECT rank, referrals FROM users WHERE displayname = ?";
    $stmt = $connection->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
        $userArray['rank'] = $row['rank'];
        $userArray['referrals'] = $row['referrals'];
    }

    return $userArray;
}

/**
 * Get a single existing user stats cached in database
 */
function getUserStatsFromAPI($connection, $user)
{
    $userArray = array();

    $query = "SELECT invite_url FROM users WHERE displayname = ?";
    $stmt = $connection->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
        $apiInfo = fetchUserStatsFromKid($row['invite_url']);
        $userArray['rank'] = explode(';', $apiInfo)[0];
        $userArray['referrals'] =explode(';', $apiInfo)[1];
    }

    return $userArray;
}

/**
 * Fetch a user stats from API
 *
 * @param $kid invite url or kid
 * @return null|string if kid is valid
 */
function fetchUserStatsFromKid($kid) {
    $apiInfo = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/oneplus_data/api.php?kid=' . $kid);
    if(!strContains($apiInfo, 'error')) {
        return $apiInfo;
    }
    return null;
}

/**
 * Add a new user in the database.
 * @return true if the user was added, otherwise false.
 */
function addNewUserInDB($username, $email, $invite_url) {
    if($connection = connectDB()) {
        if(!checkIfUserExists($connection, $username)) {
            $userStats = fetchUserStatsFromKid($invite_url);
            if (!strContains($userStats, 'error')) {
                $query = "INSERT INTO users(displayname, rank, referrals, email, invite_url) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->stmt_init();
                $stmt->prepare($query);
                $stmt->bind_param("siiss", $username, explode(';', $userStats)[0], explode(';', $userStats)[1], $email, $invite_url);
                $stmt->execute();

                $connection->close();
                return true;
            }
        }
        $connection->close();
    }
    return false;
}

/**
 * Return true if string starts with the text given
 */
function startsWith($text, $startsWith)
{
    return $startsWith === "" || strrpos($text, $startsWith, -strlen($text)) !== FALSE;
}

/**
 * Return true if string ends with the text given
 */
function endsWith($text, $endsWith) {
    return $endsWith === "" || (($temp = strlen($text) - strlen($endsWith)) >= 0 && strpos($text, $endsWith, $temp) !== FALSE);
}

/**
 * Return true if string contains the text given
 */
function strContains($text, $word) {
    return (strpos($text,$word) !== false);
}

?>