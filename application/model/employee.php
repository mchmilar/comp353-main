<?php


class employee
{
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getAllEmployees()
    {
        $sql = "SELECT uid, first_name, last_name
                FROM employee NATURAL JOIN user
                WHERE user.uid = employee.uid AND employee.end_date = 0";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}