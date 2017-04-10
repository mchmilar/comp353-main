<?php

/**
 * Created by PhpStorm.
 * User: justinwhatley
 * Date: 2017-04-07
 * Time: 3:21 PM
 */

/**
 * Class User
 * handles the user's login and logout process
 */
class Login extends Controller
{

    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    public function loadModel()
    {
        require APP . '/model/user.php';
        // create new "model" (and pass the database connection)
        $this->user = new User($this->db);
    }


    public function index()
    {
        if(isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1)
        {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects');
        }
        require APP . 'views/_templates/header.php';
        require APP . 'views/login/index.php';
        require APP . 'views/_templates/footer.php';
    }


    public function view()
    {

        require APP . 'views/login/index.php';

    }

    /**
     * log in with post data
     */
    public function attemptLogin()
    {
        // check login form contents
        if (empty($_POST['uid'])) {
            $this->errors[] = "User ID field was empty.";
            // check that password is included
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password field was empty.";
            // if both are included
        } elseif (!empty($_POST['uid']) && !empty($_POST['password'])) {

            $result_user_password = $this->user->checkPassword($_POST['uid'], $_POST['password']);

            if ($result_user_password) {
                $_SESSION['uid'] = $_POST['uid'];
                $_SESSION['user_login_status'] = 1;

                //Access level 1 for employee and 0 for customers
                $access = $this->user-> checkAccess($_POST['uid']);
                $_SESSION['access_level'] = $access->access_level;
            }
            else {
                $_SESSION['user_login_status'] = 0;
                $this->errors[] = "Wrong user ID or password. Try again.";
            }

        }

        if($_SESSION['user_login_status'] == 1) {
                header('location: ' . URL_WITH_INDEX_FILE . 'projects');
            } else {
                header('location: ' . URL_WITH_INDEX_FILE . 'login');
            }

    }


    /**
     * perform the logout
     */
    public function logout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";
        header('location: ' . URL_WITH_INDEX_FILE . 'login');
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public
    function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}