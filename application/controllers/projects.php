<?php

/**
 * Class Projects
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
        require APP . '/model/supplier.php';
        require APP . '/model/contractor.php';
        require APP . '/model/permit.php';
        // create new "model" (and pass the database connection)
        $this->project = new Project($this->db);
        $this->customer = new Customer($this->db);
        $this->task = new Task($this->db);
        $this->supplier = new Supplier($this->db);
        $this->contractor = new Contractor($this->db);
        $this->permit = new Permit($this->db);
    }


    public function index()
    {

        if(!isset($_SESSION['user_login_status']) OR $_SESSION['user_login_status'] != 1)
        {
            die(header('location: ' . URL_WITH_INDEX_FILE . 'login'));
        }

        //Gets customer specific data for users without general access
        if(isset($_SESSION['access_level']) AND $_SESSION['access_level'] != 1)
        {
            $projects = $this->project->getCustomerProjects($_SESSION['uid']);
            $customers = $this->customer->getCustomerForLimitedAccessUser($_SESSION['uid']);
        }
        else {
            $projects = $this->project->getAllProjects();
            $customers = $this->customer->getAllCustomers();
        }

        require APP . 'views/_templates/header.php';
        require APP . 'views/projects/index.php';
        require APP . 'views/_templates/footer.php';
    }


    public function addProject()
    {
        $new_pid = 0;
        $cost_estimate = $this->task->estimateTotalCost($_POST["square-feet"]);
        $time_estimate = $this->task->estimateTotalTime($_POST['square-feet']);

        // if we have POST data to create a new project
        if (isset($_POST["submit_add_project"])) {
            $new_pid = $this->project->addProject($_POST["name"], $cost_estimate, $time_estimate, $_POST["square-feet"]);
        }

        // where to go after project has been added
        if ($new_pid) {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $new_pid);
        } else {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/index');
        }

    }

    public function view($pid) {
        $customer = $this->customer->getCustomer($pid);
        $tasks = $this->task->getAllTasks();
        $suppliers = $this->supplier->getAllSuppliers();
        $contractors = $this->contractor->getAllContractors();
        $price = $this->project->price($pid);
        $estimated_complete = $this->project->estimatedComplete($pid);
        $estimated_price = $this->project->estimatedPrice($pid);
        $phase = $this->project->activePhase($pid);
        $permits = $this->permit->getAll();
        $permitsJson = json_encode($permits);

        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/body.php';
        require APP . 'views/projects/view.php';
        require APP . 'views/_templates/footer.php';
    }

}
