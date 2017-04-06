<?php

class Contractor
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

    public function getContractorIdFromName($name) {
        $sql = "SELECT cid 
                FROM contractor 
                WHERE org_name = :org_name";
        $query = $this->db->prepare($sql);
        $parameters = array(':org_name' => $name);
        $query->execute($parameters);
        return $query->fetch()->cid;
    }

    public function getContractor($cid) {
        $sql = "SELECT * 
                FROM contractor 
                WHERE cid = $cid";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }


    public function getAllContractors() {
        $sql = "SELECT * FROM contractor";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}
