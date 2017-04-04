<?php

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Projects extends Controller
{

    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    public function loadModel()
    {
        require APP . '/model/project.php';
        require APP . '/model/customer.php';
        require APP . '/model/task.php';
        // create new "model" (and pass the database connection)
        $this->project = new Project($this->db);
        $this->customer = new Customer($this->db);
        $this->task = new Task($this->db);
    }

    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */
    public function index()
    {
        // getting all songs and amount of songs
        $projects = $this->project->getAllProjects();
        $customers = $this->customer->getAllCustomers();

       // load views. within the views we can echo out $songs and $amount_of_songs easily
        require APP . 'views/_templates/header.php';
        require APP . 'views/projects/index.php';
        require APP . 'views/_templates/footer.php';
    }

    /**
     * ACTION: addSong
     * This method handles what happens when you move to http://yourproject/songs/addsong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a song" form on songs/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addProject()
    {
        $new_pid = 0;
        // if we have POST data to create a new song entry
        if (isset($_POST["submit_add_project"])) {
            // do addSong() in model/model.php
            $new_pid = $this->project->addProject($_POST["name"]);
        }

        // where to go after song has been added
        if ($new_pid) {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $new_pid);
        } else {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/index');
        }

    }

    public function view($pid) {
        $customer = $this->customer->getCustomer($pid);
        $tasks = $this->task->getAllTasks();
        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/view_project.php';
        require APP . 'views/_templates/footer.php';
    }

}
