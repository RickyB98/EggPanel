<?php
  if (isset($_POST['sent'])) {
    if (isset($showRC)) {
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $data = array('secret' => $recaptcha['secret'], 'response' => $_POST['g-recaptcha-response']);
      $options = array(
        'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data),
        ),
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      $captcha_json = json_decode($result, 1);
      if (!$captcha_json['success']) {
        $failedcaptcha = true;
      } else {
        $failedcaptcha = false;
      }
    } else {
        $failedcaptcha = false;
    }
    if ($_POST['password'] != $_POST['verpassword']) {
      $failedver = true;
    } elseif (!preg_match("/\S+@\S+\.\S+/i", $_POST['email'])) {
      $invalidemail = true;
    } else {
      $conn = new PDO($dsn, $db['user'], $db['pass']);
      $results = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
      foreach ($results as $res) {
        if (strtolower($res['email']) === strtolower($_POST['email'])) {
          $existingemail = true;
          break;
        } elseif (strtolower($res['name']) === strtolower($_POST['username'])) {
          $existinguser = true;
          break;
        }
      }
      if (!isset($existingemail) && !isset($existinguser) && !$failedcaptcha) {
        // proceed to account creation
        $prep = $conn->prepare("INSERT INTO users (id, name, password_hash, email, token_hash, verified) VALUES (NULL, :name, :passhash, :email, :tokenhash, NULL)");
        $prep->bindValue(":name", $_POST['username'], PDO::PARAM_STR);
        $prep->bindValue(":passhash", password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $prep->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        $token = generateRandomString(32);
        $prep->bindValue(":tokenhash", password_hash($token, PASSWORD_DEFAULT), PDO::PARAM_STR);
        if ($prep->execute()) {
          // sending email
          require 'PHPMailer/PHPMailerAutoload.php';
          $mailObj = new PHPMailer;
          $mailObj->isSMTP();                                      // Set mailer to use SMTP
          $mailObj->Host = $mail['smtp'];  // Specify main and backup SMTP servers
          if (!empty($mail['username'])) {
            $mailObj->SMTPAuth = true;                               // Enable SMTP authentication
            $mailObj->Username = $mail['username'];                 // SMTP username
            $mailObj->Password = $mail['password'];                           // SMTP password
          } else {
            $mailObj->SMTPAuth = false;
          }
          if (!empty($mail['encryption'])) {
            $mailObj->SMTPSecure = $mail['encryption'];                            // Enable TLS encryption, `ssl` also accepted
          }
          $mailObj->Port = $mail['port'];                                    // TCP port to connect to
          $mailObj->From = $mail['from'];
          $mailObj->FromName = $mail['name'];
          $mailObj->addAddress($_POST['email'], $_POST['username']);     // Add a recipient
          $mailObj->isHTML(true);                                  // Set email format to HTML
          $mailObj->Subject = 'EggPanel registration';
          $username = $_POST['username'];
          $mailfrom = $mail['from'];
$mailObj->Body = <<<EOT
<h1>Dear $username</h1>
<p>Thank you for registering on our service.</p>
<p>Here is your code to validate your account: <b>$token</b></p>
<p>Login into the dashboard and you'll find all the information you need to validate it.</p>
<p>If you have any question, please contact $mailfrom</p>
<p>Regards,</p>
<p>EggPanel</p>
<p>[This was an automatically generated message.]</p>
EOT;
          $mailObj->AltBody = "Dear ".$_POST['username'].",\nhere is your code to validate your account: ".$token."\nRegards,\nEggPanel\n[This was an automatically generated message]";
          if (!$mailObj->send()) {
            $success = false;
          } else {
            $success = true;
          }
        } else {
          $success = false;
        }
      }
    }
  }
?>
<div class="page-header">
<h1>Sign up</h1>
</div>
<?php if (isset($_POST['sent'])) {
if (empty($_POST['password']) || empty($_POST['verpassword']) || empty($_POST['username']) || empty($_POST['email'])) { ?>
<div class="alert alert-danger" role="alert"><strong>Missing parameter.</strong> All fields are mandatory.</div>
<?php } elseif ($failedcaptcha) { ?>
<div class="alert alert-danger" role="alert"><strong>You failed human verification.</strong> Please click on the captcha box before submitting.</div>
<?php } elseif (isset($failedver)) { ?>
<div class="alert alert-danger" role="alert"><strong>You provided two different passwords.</strong> Please make sure you type the same password in both fields.</div>
<?php } elseif (isset($invalidemail)) { ?>
<div class="alert alert-danger" role="alert"><strong>That doesn't look like a valid email address.</strong> Please provide a valid address as you will need it to verify your account.</div>
<?php } elseif (isset($existingemail)) { ?>
<div class="alert alert-danger" role="alert"><strong>It looks like there's already an account registered with that email.</strong> If you forgot your password, you can <a class="alert-link" href="/reset/">reset it</a>.</div>
<?php } elseif (isset($existinguser)) { ?>
<div class="alert alert-danger" role="alert"><strong>That username is already taken.</strong> If you think it belongs to you, but you forgot your password, please <a class="alert-link" href="/reset/">reset it</a>.</div>
<?php } elseif (isset($success)) { 
  if ($success) { ?>
<div class="alert alert-success" role="alert"><strong>Success!</strong> Please follow the instructions we sent you via email to validate your account.</div>
<?php } else { ?>
<div class="alert alert-danger" role="alert"><strong>Failed to register your account.</strong> If you see this message, please contact the system administrator ASAP.</div>
<?php } } }
if (!isset($success)) { ?>
<form action="/signup/" method="post" class="form-horizontal">
  <input type="hidden" name="sent" value="1">
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" id="email" placeholder="Please enter your email address.">
    </div>
  </div>
  <div class="form-group">
    <label for="username" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="username" id="username" placeholder="Please enter a username.">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password" id="password" placeholder="Please enter the password you would like to use.">
    </div>
  </div>
  <div class="form-group">
    <label for="verpassword" class="col-sm-2 control-label">Verify password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="verpassword" id="verpassword" placeholder="Please enter the same password to verify.">
    </div>
  </div>
<?php if (isset($showRC)) { ?>
  <div class="form-group">
    <label for="captcha" class="col-sm-2 control-label">Human verification</label>
    <div class="col-sm-10">
      <div class="g-recaptcha" id="captcha" data-sitekey="<?php echo $recaptcha['public']; ?>"></div> 
    </div>
  </div>
<?php } ?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Sign up</button>
    </div>
  </div>
</form>
<?php } ?>
