<?php
  if (isset($_POST['sent']) && $verified) {
    $prep = $conn->prepare("SELECT * FROM bots WHERE user_id=:userid AND name=:botname");
    $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
    $prep->bindValue(":botname", $_POST['botname'], PDO::PARAM_STR);
    $prep->execute();
    $res = $prep->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($res)) {
      $existing = true;      
    }
    $prep = $conn->prepare("INSERT INTO bots (id, name, user_id, active, key_hash) VALUES (NULL, :name, :userid, 0, :keyhash)");
    $prep->bindValue(":name", $_POST['botname'], PDO::PARAM_STR);
    $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
    $key = generateRandomString(20);
    $prep->bindValue(":keyhash", password_hash($key, PASSWORD_DEFAULT), PDO::PARAM_STR);
    if ($prep->execute()) {
      $created = true;
    }
  }
?>
<div class="page-header">
<h1>Add bot</h1>
</div>
<?php if (!$verified) { ?>
<div class="alert alert-danger" role="alert"><strong>Your email is not verified.</strong> You won't be able to create a bot until you verify your email.</div>
<?php } else {
if (isset($existing)) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Couldn't create the bot.</strong> There's already a bot known by that name.
</div>
<?php } ?>
<?php if (isset($created)) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Here's the API key, keep it safe: <strong><?php echo $key; ?></strong> - You're not going to see this key again. If you lose it, you'll have to generate a new one.
</div>
<?php } ?>
<form action="/dashboard/addbot/" method="post" class="form-horizontal">
  <input type="hidden" name="sent" value="1">
  <div class="form-group">
    <label for="botname" class="col-sm-2 control-label">Bot name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="botname" name="botname" placeholder="Please choose a name so that it's more specific than 'Eggdrop', 'MyBot' etc.">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
<?php } ?>
