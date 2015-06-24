<?php
header("Content-type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "global.php";
if (!isset($_POST['key']) || !isset($_POST['command'])) {
  $json['code'] = 300;
  $json['message'] = "Missing parameter.";
  echo json_encode($json);
  exit;
}
loadSettings();
// Settings
$db['host'] = "localhost"; // address of the mysql database
$db['port'] = ""; // leave blank for default
$db['user'] = "webegg"; // mysql user
$db['pass'] = "DFjdhFsWLv4tTeCH"; // mysql password
$db['database'] = "webegg"; // database name

if (!empty($db['port'])) {
  $dsn = "mysql:dbname=".$db['database'].";host=".$db['host'].";port=".$db['port'];
} else {
  $dsn = "mysql:dbname=".$db['database'].";host=".$db['host'];
}
$conn = new PDO($dsn, $db['user'], $db['pass']);
$res = $conn->query("SELECT * FROM bots");
$found = false;
foreach ($res as $el) {
  if (password_verify($_POST['key'], $el['key_hash'])) {
    $bot_record = $el;
    $user = $el['user_id'];
    $bot = $el['id'];
    $found = true;
    break;
  }
}
if (!$found) {
  $json['code'] = 400;
  $json['message'] = "Invalid API key.";
  echo json_encode($json);
  exit;
} else {
  switch (strtolower($_POST['command'])) {
  case 'fetch':
    $prep = $conn->prepare("SELECT id, command, arguments FROM actions WHERE bot_id=:bot AND executed=0");
    $prep->bindValue(":bot", $bot, PDO::PARAM_INT);
    $prep->execute();
    $results = $prep->fetchAll(PDO::FETCH_ASSOC);
    $json['code'] = 200;
    $json['message'] = $results;
    echo json_encode($json);
    break;
  case 'pickup':
    if (!isset($_POST['action'])) {
      $json['code'] = 300;
      $json['message'] = "Missing parameter.";
      echo json_encode($json);
      exit;
    }
    $prep = $conn->prepare("SELECT * FROM actions WHERE bot_id=:bot AND id=:action AND executed=0");
    $prep->bindValue(":bot", $bot, PDO::PARAM_INT);
    $prep->bindValue(":action", $_POST['action'], PDO::PARAM_INT);
    $prep->execute();
    $results = $prep->fetchAll(PDO::FETCH_ASSOC);
    if (empty($results)) {
      $json['code'] = 405;
      $json['message'] = "Action not found, already picked up, or you're not allowed to pick it up.";
      echo json_encode($json);
      exit;
    }
    $prep = $conn->prepare("UPDATE actions SET executed=1, pickup=:time, message=:message WHERE id=:id");
    $prep->bindValue(":time", time(), PDO::PARAM_INT);
    $prep->bindValue(":id", $_POST['action'], PDO::PARAM_INT);
    if (isset($_POST['message']) && !empty($_POST['message'])) {
      $prep->bindValue(":message", $_POST['message'], PDO::PARAM_STR);
    } else {
      $prep->bindValue(":message", "", PDO::PARAM_NULL);
    }
    if ($prep->execute()) {
      $json['code'] = 200;
      $json['message'] = "Success.";
    } else {
      $json['code'] = 410;
      $json['message'] = "Error executing the action.";
    }
    echo json_encode($json);
    break;
  default:
    $json['code'] = 350;
    $json['message'] = "Invalid command.";
    echo json_encode($json);
    break;
  }
}
exit;
