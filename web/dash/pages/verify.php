<?php if ($verified) { header("Location: /dashboard/"); exit; }
if (isset($_POST['sent']) && isset($_POST['code'])) {
  $prep = $conn->prepare("SELECT token_hash FROM users WHERE id=:userid");
  $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
  $prep->execute();
  $res = $prep->fetchAll(PDO::FETCH_ASSOC);
  $res = $res[0];
  if (password_verify($_POST['code'], $res['token_hash'])) {
    $prep = $conn->prepare("UPDATE users SET verified=:time WHERE id=:userid");
    $prep->bindValue(":time", time(), PDO::PARAM_INT);
    $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
    if ($prep->execute()) {
      $success = true;
    } else {
      $success = false;
    }
  } else {
    $failed = true;
  }
}
?>
<div class="page-header">
<h1>Email verification</h1>
</div>
<?php if (isset($failed)) { ?>
<div class="alert alert-danger" role="alert"><strong>Invalid code.</strong> Please make sure to copy and paste correctly the code you received in the email.</div>
<?php } 
if (isset($success)) { 
if ($success) { ?>
<div class="alert alert-success" role="alert"><strong>Success!</strong> You can now access all the features of the dashboard.</div>
<?php } else {  ?>
<div class="alert alert-danger" role="alert"><strong>Could not verify your email.</strong> If you see this message, please contact the system administrator ASAP.</div>
<?php } } 
if (!isset($success) || !$success) {
?>
<form action="/dashboard/verify" method="post" class="form-horizontal">
  <input type="hidden" name="sent" value="1">
  <div class="form-group">
    <label for="code" class="col-sm-2 control-label">Code</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="code" id="code" placeholder="Enter the code you received via email here.">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
<?php } ?>

