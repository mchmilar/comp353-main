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
        return $pid->pid;
    }

    public function addProject($name)
    {
        // get project id number to use
        $pid = $this->nextPID();
        $name = explode(' ', $name);
        $sql = "SELECT uid FROM user WHERE first_name = :first_name AND last_name = :last_name";
        $query = $this->db->prepare($sql);
        $parameters = array(':first_name' => $name[0], ':last_name' => $name[1]);
        $query->execute($parameters);
        $uid = $query->fetch()->uid;


        $sql = "INSERT INTO project (price) VALUES (:price);
                INSERT INTO purchase_project (pid, uid) VALUES (:pid, :uid);
                ";
        $default_price = 0;
        try {
            $query = $this->db->prepare($sql);
            $parameters = array(':pid' => $pid, ':uid' => $uid, ':price' => $default_price);
            $query->execute($parameters);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        return $pid;
    }


}
