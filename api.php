<?php
session_start();
include_once('functions.php');

//_$GET['kid'] can accept a full invite url or the kid only
if (isset($_GET['kid'])) {
    $kid = $_GET['kid'];
    if (startsWith($kid, "https://oneplus.net/")) {
        $parsedURL = parse_url($kid, PHP_URL_QUERY);
        parse_str($parsedURL, $params);
        if (isset($params['kolid'])) {
            $kid = $params['kolid'];
        } else {
            exit('error : invalid shareable invite link.');
        }
    }

    $url = "https://invites.oneplus.net/index.php?r=share/view&kid={$kid}";

    $JSON = file_get_contents($url);
    $JSON = json_decode($JSON);

    if (isset($JSON) && isset($JSON->data) && isset($JSON->data->kid)) {
        $rank = $JSON->data->rank;
        $referrals = $JSON->data->ref_count;

        echo $rank . ";" . $referrals; //Syntax = rank;referrals
    } else {
        exit('error : invalid kid.');
    }
} else {
    exit('error : no kid provided.');
}
?>