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
        require APP . '/model/supplier.php';
        require APP . '/model/contractor.php';
        // create new "model" (and pass the database connection)
        $this->project = new Project($this->db);
        $this->customer = new Customer($this->db);
        $this->task = new Task($this->db);
        $this->supplier = new Supplier($this->db);
        $this->contractor = new Contractor($this->db);
    }


    public function index()
    {

        $projects = $this->project->getAllProjects();
        $customers = $this->customer->getAllCustomers();


        require APP . 'views/_templates/header.php';
        require APP . 'views/projects/index.php';
        require APP . 'views/_templates/footer.php';
    }


    public function addProject()
    {
        $new_pid = 0;
        // if we have POST data to create a new project
        if (isset($_POST["submit_add_project"])) {
            $new_pid = $this->project->addProject($_POST["name"]);
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
        $phase = $this->project->activePhase($pid);
        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/view_project.php';
        require APP . 'views/_templates/footer.php';
    }

}
