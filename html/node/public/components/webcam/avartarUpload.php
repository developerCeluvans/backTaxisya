<?php

//include_once('adodb5/adodb.inc.php');

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
//$db = ADONewConnection('mysql'); # eg 'mysql' or 'postgres'
//$db->debug = true;
/*
  'mysql' => array(
  'driver' => 'mysql',
  'host' => '127.0.0.1',
  'database' => 'appsuser_taxisya', //'taxisya',
  'username' => 'appsuser', //'admin',
  'password' => 'MEbpbsC1^776<t9',
  'charset' => 'utf8',
  'prefix' => '',
 */
$server = '127.0.0.1';
$user = 'appsuser';
$password = 'MEbpbsC1^776<t9';
$database = 'appsuser_taxisya';
echo __FILE__;

//$db->Connect($server, $user, $password, $database);


$filename = "img/drivers/" . $_GET['id'] . '.jpg';
$result = file_put_contents($filename, file_get_contents('php://input'));

/* class Driver extends ADOdb_Active_Record {

  }

  $driver = new Driver();
  $driver->Load('id=' . $_GET['id']);
  $driver->picture = "cms/public/$filename";
  $driver->save(); */
//Driver::update($_GET['id'], array('picture' => "cms/public/$filename"));
/* if (!$result) {
  print "ERROR: Failed to write data to $filename, check permissions\n";
  exit();
  }

  $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
  print "$url\n"; */
?>
