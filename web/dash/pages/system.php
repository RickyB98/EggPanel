<?php
if (isset($_POST['sent'])) {
  if (!isset($_SESSION['bot_id'])) {
    $nobot = true;
  } else {
    $prep = $conn->prepare("INSERT INTO actions (id, bot_id, command, arguments, timestamp, executed, pickup, success, message) VALUES (NULL, :botid, :command, NULL, :time, 0, NULL, NULL, NULL)");
    switch (strtolower($_POST['submit'])) {
      case 'rehash':
        $prep->bindValue(":command", "rehash", PDO::PARAM_STR);
        break;
      case 'restart':
        $prep->bindValue(":command", "restart", PDO::PARAM_STR);
        break;
      case 'die':
        $prep->bindValue(":command", "die", PDO::PARAM_STR);
        break;
      default:
        header("Location: /dashboard/system/");
        break;
    }
    $prep->bindValue(":time", time(), PDO::PARAM_INT);
    $prep->bindValue(":botid", $_SESSION['bot_id'], PDO::PARAM_INT);
    $success = $prep->execute();
  }
}
?>
<div class="page-header">
<h1>System operations</h1>
</div>
<?php
if (isset($nobot)) { ?>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> You haven't selected any bot. Go <a href="/dashboard/">here</a> and click on a bot to enable these commands.
</div>
<?php }
if (isset($success)) {
  if ($success) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> The action is ready to be picked up by the bot.
</div>
<?php } else { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> Something went wrong during execution.
</div>
<?php } } ?>
<form action="/dashboard/system/" method="post" class="form-inline">
<input type="hidden" name="sent" value="1">
<button name="submit" value="rehash" class="btn btn-lg btn-success">Rehash</button>
<button name="submit" value="restart" class="btn btn-lg btn-warning">Restart</button>
<button name="submit" value="die" class="btn btn-lg btn-danger">Die</button>
</form>
