<?php
    if (isset($_POST['logout'])) {
        /* unset($_SESSION['login']);
        unset($_SESSION['username']); */
        session_destroy();
        header("Location: /dashboard/login");
        exit;
    }
    if ($page === 'login') {
      include "dash/login.php";
      exit;
    }
    if (!isset($_SESSION['login'])) {
        header("Location: /dashboard/login");
        exit;
    }
    $include = "dash/pages/";
    switch ($page) {
        case '':
        case 'index':
            $title = "EggPanel - Dashboard";
            $include .= "main.php";
            break;
        case 'addbot':
            $title = "EggPanel - Add bot";
            $include .= "addbot.php";
            break;
        case 'editbot':
            $title = "EggPanel - Edit bot";
            $include .= "editbot.php";
            break;
        case 'switch':
            $title = "";
            $include .= "switch.php";
            break;
        case 'logs':
            $title = "EggPanel - Logs";
            $include .= "logs.php";
            break;
        case 'system':
            $title = "EggPanel - System operations";
            $include .= "system.php";
            break;
        case 'verify':
          $title = "EggPanel - Email verification";
          $include .= "verify.php";
          break;
        default:
            $title = "EggPanel - 404 (Not found)";
            $include .= "404.php";
            break;
    }
    $conn = new PDO($dsn, $db['user'], $db['pass']);
    $prep = $conn->prepare("SELECT * FROM bots WHERE user_id=:user");
    $prep->bindValue(":user", $_SESSION['user_id'], PDO::PARAM_INT);
    $prep->execute();
    foreach ($prep->fetchAll(PDO::FETCH_ASSOC) as $bot) {
      $prep = $conn->prepare("SELECT last FROM requests WHERE bot_id=:bot");
      $prep->bindValue(":bot", $bot['id'], PDO::PARAM_INT);
      $prep->execute();
      $reqs = $prep->fetchAll(PDO::FETCH_ASSOC);
      if (empty($reqs)) {
        $status[$bot['id']] = false;
      } else {
        $req = $reqs[0];
        if ((time() - $req['last']) > 30) {
          $status[$bot['id']] = false;
        } else {
          $status[$bot['id']] = true;
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link rel="icon" href="../../favicon.ico"/>
        
        <title><?php echo $title; ?></title>
        
        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        
        <!-- Custom styles for this template -->
        <link href="/css/dashboard.css" rel="stylesheet"/>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
         <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
         <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">EggPanel</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                   <form action="/dashboard/" method="post" class="navbar-form navbar-right">
                        <input type="hidden" name="logout">
                        <button type="submit" class="btn btn-default">Logout</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                    <li><a>Welcome back, <?php echo htmlspecialchars($_SESSION['user']); ?>!<?php if (isset($_SESSION['bot_id'])) { ?> (currently operating on <?php echo $_SESSION['botname']; ?>)<?php } ?></a></li>
                    </ul> 
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                    <li <?php if ($page === "index") echo "class=\"active\""; ?>><a href="/dashboard/">Overview</a></li>
                    <li <?php if ($page === "addbot") echo "class=\"active\""; ?>><a href="/dashboard/addbot/">Add bot</a></li>
                    <li <?php if ($page === "logs") echo "class=\"active\""; ?>><a href="/dashboard/logs/">Logs</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li <?php if ($page === "system") echo "class=\"active\""; ?>><a href="/dashboard/system/">System operations</a></li>
                        <li><a href="">User management</a></li>
                        <li><a href="">Add user</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Channel list</a></li>
                        <li><a href="">Join channel</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php
    $prep = $conn->prepare("SELECT verified FROM users WHERE id=:userid");
    $prep->bindValue(":userid", $_SESSION['user_id'], PDO::PARAM_INT);
    $prep->execute();    
    $res = $prep->fetchAll(PDO::FETCH_ASSOC);
    $res = $res[0];
    $verified = is_null($res['verified']) ? false : true;
    if (!$verified) { ?>
<div id="notverified" class="alert alert-warning" role="alert"><strong>You haven't verified your email yet.</strong> <a href="/dashboard/verify/">Click here</a> to verify your email address.</div>
<?php } ?>
                    <?php include $include; ?>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap core JavaScript
         ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php if ($page === 'verify' && isset($success) && $success) { ?>
      <script type="text/javascript">
$(function e () { $('#notverified').hide() } )
      </script>
<?php } ?>
        <script src="/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="/js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>
