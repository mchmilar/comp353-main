<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<!DOCTYPE html>
<html>

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

<a id="popup" href="#" data-toggle="modal" data-target="#login-modal"></a>


<div>
    <form action="<?php echo URL_WITH_INDEX_FILE; ?>login/attemptLogin" method="POST">

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Login to Your Account</h1><br>
                    <form>
                        <input type="text" name="uid" placeholder="User ID">
                        <input type="password" name="password" placeholder="Password">
                        <input id="button" type="submit" name="submit_login" class="login loginmodal-submit">
                    </form>

        <!--            <div class="login-help">-->
        <!--                <a href="#">Register</a> - <a href="#">Forgot Password</a>-->
        <!--            </div>-->
                </div>
            </div>
        </div>
    </form>
</div>

<!---->
<!--<div>-->
<!--    <form action="--><?php //echo URL_WITH_INDEX_FILE; ?><!--login/attemptLogin" method="POST">-->
<!--        <label for="uid">-->
<!--            User ID: <br>-->
<!--            <input type="text" name="uid" id="uid" placeholder="Enter user ID"/>-->
<!--        </label>-->
<!---->
<!--        <label for="password">-->
<!--            Password: <br>-->
<!--            <input type="password" name="password" id="password" placeholder="Enter your password"/>-->
<!--        </label>-->
<!--        <input id="button" type="submit" name="submit_login"> </input>-->
<!--    </form>-->
<!--</div>-->


</body>
</html>
