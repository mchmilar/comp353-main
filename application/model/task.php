<?php

class Task
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function filterTasks($desc, $phase, $cFactorCond,
     $cFactor,
     $cBaseCond,
     $cBase,
     $tFactorCond,
     $tFactor,
     $tBaseCond,
     $tBase) {
       $sql = "select * from task natural join phase
                where lower(description) like lower(:desc)".
           (($phase) ? "and phase_id = :phase" : "")
                ."and cost_per_sq_foot " . $cFactorCond . " :cFactor
                and base_cost " . $cBaseCond . " :cBase
                and time_per_sq_foot " . $tFactorCond . " :tFactor
                and base_time " . $tBaseCond . " :tBase";
        $query = $this->db->prepare($sql);
        $parameters = array(':desc' => "%$desc%",
            ':phase' => $phase,
            ':cFactorCond' => $cFactorCond,
            ':cFactor' => (($cFactor) ? $cFactor : 0),
            ':cBaseCond' => $cBaseCond,
            ':cBase' => (($cBase) ? $cBase : 0),
            ':tFactorCond' => $tFactorCond,
            ':tFactor' => (($tFactor) ? $tFactor : 0),
            ':tBaseCond' => $tBaseCond,
            ':tBase' => (($tBase) ? $tBase : 0)
            );
        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        return $query->fetchAll();
    }
    public function getTask($tid) {
        $sql = "SELECT * 
                FROM task 
                WHERE tid = $tid";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Get all customers from the database
     */
    public function getAllTasks() {
        $sql = "SELECT * FROM task NATURAL JOIN phase";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function estimateTotalTime($square_feet) {
        $sql = "SELECT time_per_sq_foot as multiplier, base_time FROM task";
        $query = $this->db->prepare($sql);

        if ($query->execute()) {
            $tasks = $query->fetchAll();
            $estimate = 0.0;
            // Apply our formula
            foreach ($tasks as $task) {
                $estimate += ($task->multiplier * $square_feet + $task->base_time);
            }

            return $estimate;
        } else {
            throw new Exception("Get task multiplier and base cost error");
        }
    }

    public function estimateTotalCost($square_feet) {
        $sql = "SELECT cost_per_sq_foot as multiplier, base_cost FROM task";
        $query = $this->db->prepare($sql);

        if ($query->execute()) {
            $tasks = $query->fetchAll();
            $estimate = 0.0;
            // Apply our formula
            foreach ($tasks as $task) {
                $estimate += ($task->multiplier * log($square_feet) + $task->base_cost);
            }

            return $estimate;
        } else {
            throw new Exception("Get task multiplier and base cost error");
        }

    }
}
