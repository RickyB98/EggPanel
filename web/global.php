<?php
session_start();
function loadSettings($file = "../settings.php") {
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
  } else {
    return true;
  }
}
