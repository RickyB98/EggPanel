<?php

define("EGGPANEL", true);

$page = isset($_GET['page']) ? strtolower($_GET['page']) : "";

switch ($page) {
  case '':
  case 'index':
    $title = "EggPanel - Home";
    $include = "pages/main.php";
    break;
  case 'about':
    $title = "EggPanel - About";
    $include = "pages/about.php";
    break;
  case 'faq':
    $title = "EggPanel - FAQ";
    $include = "pages/faq.php";
    break;
  case 'downloads':
    $title = "EggPanel - Downloads";
    $include = "pages/downloads.php";
    break;
  case 'contact':
    $title = "EggPanel - Contact";
    $include = "pages/contact.php";
    break;
  default:
    $title = "EggPanel - 404 (Not Found)";
    $include = "pages/404.php";
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
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">EggPanel</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <?php if (in_array($page, array('', 'index'))) echo "class=\"active\""; ?>><a href="index.php">Home</a></li>
              <li <?php if ($page === "about") echo "class=\"active\""; ?>><a href="?page=about">About</a></li>
              <li <?php if ($page === "faq") echo "class=\"active\""; ?>><a href="?page=faq">FAQ</a></li>
              <li <?php if ($page === "downloads") echo "class=\"active\""; ?>><a href="?page=downloads">Downloads</a></li>
              <li <?php if ($page === "contact") echo "class=\"active\""; ?>><a href="?page=contact">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="dashboard/">Dashboard</a></li>
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
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
