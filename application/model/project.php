<?php

class Project
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

    /**
     * Get all songs from database
     */
    public function getAllProjects()
    {
        $sql = "SELECT pid, price, first_name, last_name FROM project natural join purchase_project natural join user";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }


    public function nextPID() {
        $sql = "SELECT max(pid) as pid FROM project";
        $query = $this->db->prepare($sql);
        $query->execute();
        $pid = $query->fetch();
        return $pid->pid + 1;
    }

    public function price($pid) {
        $sql = "SELECT price FROM project WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid);
        $query->execute($parameters);
        return $query->fetch()->price;
    }

    public function estimatedComplete($pid) {
        $sql = "SELECT estimated_complete FROM project WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid);
        $query->execute($parameters);
        return $query->fetch()->estimated_complete;
    }

    public function estimatedPrice($pid) {
        $sql = "SELECT estimated_price FROM project WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid);
        $query->execute($parameters);
        return $query->fetch()->estimated_price;
    }

    public function activePhase($pid) {
        $sql = "SELECT name FROM phase NATURAL JOIN active_phase WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        return $query->fetch()->name;
    }

    // time estimate is in days. it will be converted to a estimated date
    public function addProject($name, $cost_estimate, $time_estimate, $square_feet)
    {
        // get project id number to use
        $pid = $this->nextPID();

        // Get user id from provided name
        $name = explode(' ', $name);
        $sql = "SELECT uid FROM user WHERE first_name = :first_name AND last_name = :last_name";
        $query = $this->db->prepare($sql);
        $parameters = array(':first_name' => $name[0], ':last_name' => $name[1]);
        $query->execute($parameters);
        $uid = $query->fetch()->uid;
        // Comment out when done.
        date_default_timezone_set('America/Toronto');
        $time_string = "+" . (int)$time_estimate . " days";
        $estimated_complete = date('Y-m-d', strtotime($time_string));

        $sql = "INSERT INTO project (price, estimated_price, estimated_complete, square_feet) 
                VALUES (:price, :estimated_price, :estimated_complete, :square_feet);
                INSERT INTO purchase_project (pid, uid) VALUES (:pid, :uid);
                ";
        $default_price = 0;

        try {
            $query = $this->db->prepare($sql);
            $parameters = array(':pid' => $pid, ':uid' => $uid, ':price' => $default_price,
                ':estimated_price' => $cost_estimate, ':square_feet' => $square_feet,
                ':estimated_complete' => $estimated_complete);
//            echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters) . " cost_estimate = $cost_estimate";  exit();
            if (!$query->execute($parameters)) {
                throw new Exception("Error adding project");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        return $pid;
    }


}
