<?php

class Customer
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

    public function getCustomer($pid) {
        $sql = "SELECT first_name, last_name 
                FROM user natural join customer natural join purchase_project 
                WHERE pid = $pid";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Get all customers from the database
     */
    public function getAllCustomers() {
        $sql = "SELECT first_name, last_name FROM user natural join customer";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}
