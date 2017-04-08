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
class Tasks extends Controller
{

    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    public function loadModel()
    {
        require APP . '/model/task.php';
        require APP . '/model/phase.php';
        // create new "model" (and pass the database connection)
        $this->task = new Task($this->db);
        $this->phase = new Phase($this->db);
    }

    public function filterTasks()
    {
        $new_pid = 0;

        $desc = $_POST['description'];
        $phase = $_POST['phase'];
        $cFactorCond = $this->translateCondition($_POST['cost-factor-condition']);
        $cFactor = $_POST['cost-factor'];
        $cBaseCond = $this->translateCondition($_POST['cost-base-condition']);
        $cBase = $_POST['cost-base'];
        $tFactorCond = $this->translateCondition($_POST['time-factor-condition']);
        $tFactor = $_POST['time-factor'];
        $tBaseCond = $this->translateCondition($_POST['time-base-condition']);
        $tBase = $_POST['time-base'];


        // if we have POST data to create a new project
        if (isset($_POST["submit_task_filter"])) {
            $new_pid = $this->task->filterTasks($desc , $phase, $cFactorCond, $cFactor, $cBaseCond, $cBase, $tFactorCond, $tFactor, $tBaseCond, $tBase);
        }

        // where to go after project has been added
        if ($new_pid) {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $new_pid);
        } else {
            header('location: ' . URL_WITH_INDEX_FILE . 'projects/index');
        }

    }

    private function translateCondition($condition) {
        if ($condition === "greater-than") return ">";
        elseif ($condition === "less-than") return "<";
        elseif ($condition === "greater-or-equal") return ">=";
        elseif ($condition === "less-or-equal") return "<=";
        else return "=";
    }

    public function index()
    {

        $tasks = $this->task->getAllTasks();
        $phases = $this->phase->getAllPhases();


        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/body.php';
        require APP . 'views/tasks/index.php';
        require APP . 'views/_templates/footer.php';
    }

/*
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

    }*/


}
