<?php

$service_id = $_GET['id'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://apps.imaginamos.com.co/taxisya/public/service/request_timed/" . $service_id);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($ch);
curl_close($ch);
echo "<p>" . $output . "<p>";
?>
 