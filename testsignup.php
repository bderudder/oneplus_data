<?php

session_start();

include_once("functions.php");

//getting POST-variables from form//

$displayname = $_POST['disname'];
$email = $_POST['email'];

//getting API FROM Oneplus//

$url = "https://invites.oneplus.net/index.php?r=share/signup&success_jsonpCallback=success_jsonpCallback&email=" . $email . "&koid=6GJ8S&_=1438659411445";

$JSON = file_get_contents($url);
$JSON = substr(substr($JSON, 22), 0, -1);
$JSON = (json_decode($JSON));

$rank = $JSON->data->rank;
$referrals = $JSON->data->ref_count;

//END API//


// Create connection
$conn = connectDB();

// Check connection
echo checkConnection($conn);

checkIfUserExists($displayname, $conn, $email);

?>