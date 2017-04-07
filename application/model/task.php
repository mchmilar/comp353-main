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
        $sql = "SELECT * FROM task";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function estimateTotalTime($square_feet) {
        $sql = "SELECT time_per_sq_foot_mult as multiplier, base_time FROM task";
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
        $sql = "SELECT cost_per_sq_foot_mult as multiplier, base_cost FROM task";
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
