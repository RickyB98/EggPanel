<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
    if (isset($_GET['logout'])) {
        unset($_SESSION['login']);
        unset($_SESSION['username']);
        header("Location: login.php?logout");
        exit;
    }
    $page = isset($_GET['page']) ? strtolower($_GET['page']) : "";
    switch ($page) {
        case '':
        case 'index':
            $title = "EggPanel - Dashboard";
            $include = "pages/main.php";
            break;
        default:
            $title = "EggPanel - 404 (Not found)";
            $include = "pages/404.php";
            break;
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
        <link href="../css/bootstrap.min.css" rel="stylesheet"/>
        
        <!-- Custom styles for this template -->
        <link href="../css/dashboard.css" rel="stylesheet"/>
        
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
                    <a class="navbar-brand" href="index.php">EggPanel</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                   <form action="index.php" method="get" class="navbar-form navbar-right">
                        <input type="hidden" name="logout">
                        <button type="submit" class="btn btn-default">Logout</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                      <li><a>Welcome back, <?php echo htmlspecialchars($_SESSION['user']); ?>!</a></li>
                    </ul> 
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="active"><a href="#">Overview</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Nav item</a></li>
                        <li><a href="">Nav item again</a></li>
                        <li><a href="">One more nav</a></li>
                        <li><a href="">Another nav item</a></li>
                        <li><a href="">More navigation</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Nav item again</a></li>
                        <li><a href="">One more nav</a></li>
                        <li><a href="">Another nav item</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <?php include $include; ?>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap core JavaScript
         ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>
