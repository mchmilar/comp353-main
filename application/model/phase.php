<?php

class Phase
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

    public function getIdFromName($name) {
        $sql = "SELECT phase_id 
                FROM phase 
                WHERE name = :name";
        $query = $this->db->prepare($sql);
        $parameters = array(':name' => $name);
        $query->execute($parameters);
        return $query->fetch()->phase_id;
    }

    public function getAllPhases() {
        $sql = "SELECT * 
                FROM phase";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}
