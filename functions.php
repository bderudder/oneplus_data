<?php 
//connecting with the database//

function connectDB(){


	//values for local//

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "oneplusdata";

	//end local values//

	//values for online//
	//end online values//

	$conn = new mysqli($servername, $username, $password, $dbname);

	return $conn;
}

//end connecting with the database//

//--------------------------

//checking your Connection with an Echo or print//

function checkConnection($connection)
{
	if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
	} 
}

//end checking your connection//

//--------------------------

//show first 5 ranks with username, rank and referrals in one userArray//

function showFirstFive($connection, $sort){

	$userArray;

	if($sort == 0 || empty($sort)){
		$sql = "SELECT rank, referrals, displayname FROM users ORDER BY rank ASC, referrals DESC LIMIT 5";
	}else if ($sort == 1){
		$sql = "SELECT rank, referrals, displayname FROM users ORDER BY referrals DESC, rank ASC LIMIT 5";
	}

	$count = 0;

	$result = $connection->query($sql);

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$count++;
			$userArray[$count]['username'] = $row["displayname"];
			$userArray[$count]['rank'] = $row["rank"];
			$userArray[$count]['referrals'] = $row["referrals"];
		}
	} else {
		echo "0 results";
	}

	return $userArray;
}

//end show first 5 ranks//

//--------------------------

//Show total users that have registered on the website with an echo//

function totalUsersRegistered($connection)
{
	$sql = "SELECT COUNT(*) FROM `users`";

	$result = $connection->query($sql);

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
	       $total_users = $row['COUNT(*)'];
	    }
	} else {
	    echo "0 results";
	}

	return $total_users;
}

//end of showing total users//

//--------------------------

//Check if User Already exists on in our Database//
function checkIfUserExists($user, $connection, $email)
{	$query = 'SELECT displayname FROM users WHERE displayname = ?';
	$stmt = $connection->stmt_init();
	$stmt->prepare($query);
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_array(MYSQLI_NUM))
	{
		$exist = $row;
	}

	if(empty($exist)){
		$stmt = $connection->prepare('INSERT INTO `users` (`displayname`, `email`, `rank`, `referrals`) VALUES (?, ?, ?, ?);');
		$stmt-> bind_param('ssii', $user, $email, $rank, $referrals);
		$stmt->execute();

		$connection -> close();
		header("location:detail.php?user=".$user."&email=".$email."");
	}
	else{
		$connection -> close();
		$_SESSION['message'] = "You are already registered on this site";
		header("location:detail.php?user=".$user."&email=".$email."");
	}
}

//end check if users are registered //

//--------------------------

//get values from one user//
function getUserStats($connection, $user){
	$userArray;
	$query = "SELECT rank, referrals FROM users WHERE `DisplayName` = ?";
	$stmt = $connection->stmt_init();
	$stmt->prepare($query);
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_array(MYSQLI_NUM))
	{
		$userArray['rank'] = $row[0];
		$userArray['referrals'] = $row[1];
	}

	return $userArray;
}

?>