<?php

function sec_session_start() {
    $session_name = 'sec_session_id'; // Set a custom session name
    /*Sets the session name.
     **This must come before session_set_cookie_params due to an undocumented bug/feature in PHP.
     **/

    session_name($session_name);

    $secure = true;

    // This stops JavaScript being able to access the session id
    $httponly = true;
    // Forces sessions to only use cookies
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
      header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
      exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_get_cookie_params($cookieParams["lifetime"],
      $cookieParams["path"],
      $cookieParams["domain"],
      $secure,
      $httponly);

    session_start();  // Start the PHP session
    session_regenerate_id(true); // regenerated the session, delete the old one.
}

function login($username, $password $db) {
    $sql = "SELECT username, password FROM user WHERE username = :username";
    $query = $db->prepare($sql);
    $parameters = array(':username' => $username);

    $query->execute($parameters);
    $result = $query->fetch();

    if ($result) {
        $dbpassword = $result['password'];
        if ($dbpassword == $password) {
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['username'] = $username;
            $_SESSION['login_string'] = hash('sha512', $dbpassword . $user_browser);

            // login successful
            return true;
        } else {
            // Password is not correct
            return false;
        }
    } else {
        // No user exists
        return false;
    }
}

function login_check($db) {
    // Check if all session variables are 
    if (isset($_SESSION['username'], $_SESSION['login_string'])) {
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $sql = "SELECT password FROM user where username = :username";
        $query = $db->prepare($sql);
        $parameters = array(':username' => $username);
        $query->execute($parameters);
        $result = $query->fetch();

        if ($result) {
            $dbpassword = $result['password'];
            $login_check = hash('sha512', $dbpassword . $user_browswer);


    
