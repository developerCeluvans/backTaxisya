<?php

/*
  Uploadify
  Copyright (c) 2012 Reactive Apps, Ronnie Garcia
  Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

// Define a destination
//$targetFolder = './uploads'; // Relative to the root
$targetFolder = '../../img/drivers/';
if (!is_dir($targetFolder)) {
    mkdir($targetFolder, 0777);
} else {
    chmod($targetFolder, 0777);
}

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    //$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $targetPath = $targetFolder;
    $targetFile = rtrim($targetPath, '/') . '/' . $_POST['dfn']; // $_FILES['Filedata']['name'];
    // Validate the file type
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    if (in_array($fileParts['extension'], $fileTypes)) {
        move_uploaded_file($tempFile, $targetFile);
        chmod($targetFile, 0777);
        echo '1';
        echo $targetFile;
        echo '<pre>' . var_dump($_FILES) . '</pre>';
        echo $_SERVER['SCRIPT_FILENAME'];
    } else {
        echo 'Invalid file type.';
    }
}
?>