<?php

class Permit
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

    public function getPermit($perm_num) {
        $sql = "SELECT * 
                FROM permit 
                WHERE perm_num = :perm_num";
        $parameters = array(':perm_num' => $perm_num);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }

    /**
     * Get all customers from the database
     */
    public function getAll() {
        $sql = "SELECT * FROM permit";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}
