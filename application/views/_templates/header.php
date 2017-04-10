<?php

// This here blocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
// "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
// If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
// Also make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
if (!$this) {
    exit(header('HTTP/1.0 403 Forbidden'));
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Damavand Construction</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="/public/css/style.css" rel="stylesheet">


</head>
<body>
<!-- header -->
<nav class="navbar navbar-default damavand-navbar">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
          <!-- href changed so that DAMAVAND links to home page-->
          <a class="navbar-brand" href="/index.php">DAMAVAND</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
                    // Link to projects page.
                    echo '<li class="active"><a href="/index.php/projects">Projects</a></li>';
                }
                if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1 AND $_SESSION['access_level'] == 1) {
                    // Link to Tasks page.
                    echo '<li><a href="/index.php/tasks">Tasks</a></li>';
                    // Link to Suppliers page
                    echo '<li><a href="/index.php/suppliers">Suppliers</a></li>';
                    // Link to contractors page
                    echo '<li><a href="/index.php/contractors">Contractors</a></li>';
                }

                ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>login/logout">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<!--     <div class="container">
    Info
    <div class="where-are-we-box">
        Everything in this box is loaded from <strong>application/views/_templates/header.php</strong> !
        <br>
        The green line is added via JavaScript (to show how to integrate JavaScript).
    </div>
    <h1>The header (used on all pages)</h1>
    demo image
    <h3>Demo image, to show usage of public/img folder</h3>
    <div>
        <img src="public/img/demo-image.png" alt="Demo image">
    </div>
    navigation
    <h3>Demo Navigation</h3>
    <div class="navigation">
        <ul>
            same like "home" or "home/index"
            <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>"><?php echo URL_WITH_INDEX_FILE; ?>home</a></li>
            <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>home/exampleone"><?php echo URL_WITH_INDEX_FILE; ?>home/exampleone</a></li>
            <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>home/exampletwo"><?php echo URL_WITH_INDEX_FILE; ?>home/exampletwo</a></li>
            "songs" and "songs/index" are the same
            <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>songs/"><?php echo URL_WITH_INDEX_FILE; ?>songs/index</a></li>
        </ul>
    </div>
    simple div for javascript output, just to show how to integrate js into this MVC construct
    <h3>Demo JavaScript</h3>
    <div id="javascript-header-demo-box">
    </div>
</div> -->
