<?php
include '/html/connection.php';

function shst($url){
	# production EMV file that calls this.
	$sql_select = "SELECT * FROM api WHERE id = 2";
	$result = $conn->query($sql_select);
	$keyRow = $result->fetch_assoc();

    $key = $keyRow['api_key'];//your key
    $curl_url = "https://api.shorte.st/s/".$key."/".$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($result);
    $shortest = $array->shortenedUrl;
    return $shortest;
}

echo shst('www.google.com');

?>
