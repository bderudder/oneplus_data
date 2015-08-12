<?php

include_once("functions.php");

//Used to fill textbox automatically when wrong invite url has been given
$prevUsername = (isset($_GET['disname']) ? $_GET['disname'] : '');
$prevEmail = (isset($_GET['email']) ? $_GET['email'] : '');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OnePlus Reservation Data</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/mediascreen.css">
    <link rel="stylesheet" href="css/ladda.min.css">
    <!-- ladda is required for loading buttons -->
    <script language="javascript" type="text/javascript">
        function doReload(catid) {
            document.location = 'index.php?sort=' + sort;
        }
    </script>
    <script src="js/modernizr.custom.js"></script>
</head>

<body>