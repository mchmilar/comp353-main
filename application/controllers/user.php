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
class User extends Controller
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

        #if it's an employee, give full access
        $projects = $this->project->getAllProjects();
        $customers = $this->customer->getAllCustomers();

        #if it's a customer, give access to customer's projects and prevent changes to anything but
        #personal information
        #$projects = $this->project->getUserProjects();

        require APP . 'views/_templates/header.php';
        require APP . 'views/projects/index.php';
        require APP . 'views/_templates/footer.php';
    }


    public function view()
    {

        require APP . 'views/_templates/login.php';

    }


    /**
     * log in with post data
     */
    private function attemptLogin()
    {
        // check login form contents
        if (empty($_POST['uid'])) {
            $this->errors[] = "Uid field was empty.";
            // check that password is included
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password field was empty.";
            // if both are included
        } elseif (!empty($_POST['uid']) && !empty($_POST['password'])) {


            $valid_user = $this->user->checkUser($_POST['uid']);
            if ($valid_user->num_rows != 1) {
                $this->errors[] = "Invalid user id.";
            }

            $result_user_password = $this->user->isUserLoggedIn($_POST['uid'], $_POST['password']);
            // if this user exists
            if ($result_user_password->num_rows == 1) {
                // get result row (as an object)
                $result_row = $result_user_password->fetch_object();

                $_SESSION['uid'] = $result_row->user_name;
                $_SESSION['user_login_status'] = 1;


            } else {
                $this->errors[] = "Wrong password. Try again.";
            }
        } else {
            $this->errors[] = "This user does not exist.";
        }
    }


    /**
     * perform the logout
     */
    public
    function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";
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
        // default return
        return false;
    }
}

?>
}