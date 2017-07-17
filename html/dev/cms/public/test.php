<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */

$filename = "img/drivers/" . $_GET['id'] . '.jpg';
chmod("img/drivers/", 0777);
$result = file_put_contents($filename, file_get_contents('php://input'));
chmod("$filename", 0777);
//Driver::update($_GET['id'], array('picture' => "cms/public/$filename"));
if (!$result) {
    print "ERROR: Failed to write data to $filename, check permissions\n";
    exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
print "$url\n";
?>
