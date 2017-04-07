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

<section id="login">
    <h2> Welcome:</h2>
    <form id=" form1" method="post" class="classA" action="login.php">
        <label for="username">
            user: <br>
            <input type="text" name="sname" id="username" placeholder="Enter your Username"/>
        </label>

        <label for="password">
            Password: <br>
            <input type="password" name="password" id="password" placeholder="Enter your Password"/>
        </label>
        <input id="button" type="submit" name="submit"> </input>
        <?php
        if ($failedLogin)
            echo "<div id='failedLogin'><p>*Error. Please Enter Valid Credentials.</p></div>"
        ?>
    </form>
</section>


</body>
</html>
