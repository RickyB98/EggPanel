<?php
define("EGGPANEL", true);
$include = "frontend/pages/";
switch ($page) {
  case '':
  case 'index':
    $title = "EggPanel - Home";
    $include .= "main.php";
    break;
  case 'about':
    $title = "EggPanel - About";
    $include .= "about.php";
    break;
  case 'faq':
    $title = "EggPanel - FAQ";
    $include .= "faq.php";
    break;
  case 'downloads':
    $title = "EggPanel - Downloads";
    $include .= "downloads.php";
    break;
  case 'contact':
    $title = "EggPanel - Contact";
    $include .= "contact.php";
    break;
  case 'signup':
    $title = "EggPanel - Sign up";
    $include .= "signup.php";
    if (isset($recaptcha['enabled']) && $recaptcha['enabled']) {
      $showRC = true;
    }
    break;
  default:
    $title = "EggPanel - 404 (Not Found)";
    $include .= "404.php";
    break;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Eggdrop Panel - Eggdrop's graphical interface">
    <meta name="author" content="Riccardo Bello">
    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
        <meta itemprop="name" content="Riccardo Bello"></span>
    <meta itemprop="softwareVersion" content="1.0">
    <meta itemprop="url" content="https://eggpanel.tk/">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if (isset($showRC)) { ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php } ?>
  </head>

  <body>
    <div itemscope itemtype="http://schema.org/SoftwareApplication" class="container">
      <!-- Static navbar -->
      <nav itemscope itemtype="http://schema.org/SoftwareApplication" class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a itemscope itemtype="http://schema.org/SoftwareApplication" class="navbar-brand" href="/"><span itemprop="name">EggPanel</span></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <?php if (in_array($page, array('', 'index'))) echo "class=\"active\""; ?>><a href="/">Home</a></li>
              <li <?php if ($page === "about") echo "class=\"active\""; ?>><a href="/about">About</a></li>
              <li <?php if ($page === "faq") echo "class=\"active\""; ?>><a href="/faq">FAQ</a></li>
              <li <?php if ($page === "downloads") echo "class=\"active\""; ?>><a itemprop="downloadUrl" href="/downloads">Downloads</a></li>
              <li <?php if ($page === "contact") echo "class=\"active\""; ?>><a href="/contact">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="/dashboard/">Dashboard</a></li>
              <li <?php if ($page === "signup") echo "class=\"active\""; ?>><a href="/signup/">Sign up</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <?php include $include; ?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
