<?php

class Supplier
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

    public function getSupplier($sid) {
        $sql = "SELECT * 
                FROM supplier 
                WHERE sid = $sid";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Get all customers from the database
     */
    public function getAllSuppliers() {
        $sql = "SELECT * FROM supplier";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}