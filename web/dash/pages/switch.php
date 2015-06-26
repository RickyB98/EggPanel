<?php
  // arg
  $prep = $conn->prepare("SELECT * FROM bots WHERE user_id=:userid AND id=:botid");
  $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
  $prep->bindValue(":botid", $arg, PDO::PARAM_INT);
  $prep->execute();
  $results = $prep->fetchAll(PDO::FETCH_ASSOC);
  if (empty($results)) {
    header("Location: /dashboard/");
    exit;
  }
  $_SESSION['botname'] = $results[0]['name'];
  $prep = $conn->prepare("UPDATE bots SET active=0 WHERE user_id=:userid");
  $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
  $prep->execute();
  $prep = $conn->prepare("UPDATE bots SET active=1 WHERE id=:botid");
  $prep->bindValue(":botid", $arg, PDO::PARAM_INT);
  $prep->execute();
  $_SESSION['bot_id'] = $arg;
  header("Location: /dashboard/");
  exit;
?>
