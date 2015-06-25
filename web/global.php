<?php
session_start();
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$file = "settings.php";
  if (!file_exists($file)) {
    die("No settings file found.");
  }
  include $file;
  if (!isset($db['host'])) {
    $issues[] = "Hostname is missing.";
  }
  if (!isset($db['port'])) {
    $issues[] = "Port is missing.";
  }
  if (!isset($db['user'])) {
    $issues[] = "Database user is missing.";
  }
  if (!isset($db['pass'])) {
    $issues[] = "Database password is missing.";
  }
  if (!isset($db['database'])) {
    $issues[] = "Database name is missing.";
  }
  if (isset($issues)) {
    die("Error in the settings file: ".implode(" ", $issues));
  }
  if (!empty($db['port'])) {
    $dsn = "mysql:dbname=".$db['database'].";host=".$db['host'].";port=".$db['port'];
  } else {
    $dsn = "mysql:dbname=".$db['database'].";host=".$db['host'];
  }

