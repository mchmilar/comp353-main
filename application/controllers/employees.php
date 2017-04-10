<?php

class employees extends Controller

{
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    public function loadModel()
    {
        require APP . '/model/employee.php';

        // create new "model" (and pass the database connection)
        $this->employee = new Employee($this->db);

       }

    public function index()
    {
        $employees = $this->employee->getAllEmployees();

        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/body.php';
        require APP . 'views/employee/index.php';
        require APP . 'views/_templates/footer.php';
    }

}