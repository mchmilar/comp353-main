<?php

// This here blocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
// "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
// If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
// Also make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
if (!$this) {
    exit(header('HTTP/1.0 403 Forbidden'));
}





?><!DOCTYPE html>
<html>

<head>
</head>
<body>

<!--<div>-->
<!--    <h3>Login</h3>-->
<!--    <form action="--><?php //echo URL_WITH_INDEX_FILE; ?><!--users/attemptLogin" method="POST">-->
<!--        <label>Name</label>-->
<!--        -->
<!--        <select name="name">-->
<!--            --><?php //foreach ($customers as $customer) {
//                echo '<option value="' . $customer->first_name . ' '. $customer->last_name .'">'
//                    . $customer->first_name . ' '. $customer->last_name
//                    . '</option>';
//            } ?>
<!--        </select>-->
<!--        <label>Square Feet</label>-->
<!--        <input name="square-feet" type="text">-->
<!--        <input type="submit" name="submit_add_project" value="Submit" />-->
<!--    </form>-->
<!--</div>-->


<div>
<!--    <form id=" form1" method="post" class="classA" action="login.php">-->
    <form action="<?php echo URL_WITH_INDEX_FILE; ?>users/attemptLogin" method="POST">
        <label for="uid">
            User ID: <br>
            <input type="text" name="uid" id="uid" placeholder="Enter user ID"/>
        </label>

        <label for="password">
            Password: <br>
            <input type="password" name="password" id="password" placeholder="Enter your password"/>
        </label>
        <input id="button" type="submit" name="submit_login"> </input>
    </form>
</div>


</body>
</html>
