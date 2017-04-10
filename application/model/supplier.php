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

    public function getSupplierIdFromName($name) {
        $sql = "SELECT sid 
                FROM supplier 
                WHERE name = :name";
        $query = $this->db->prepare($sql);
        $parameters = array(':name' => $name);
        $query->execute($parameters);
        return $query->fetch()->sid;
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

    public function getSupplierAddress($sid)
    {
        $sql = "SELECT sid, street, city, province,
                postal_code, house_num, country
                FROM supplier_address natural join address
                WHERE sid = $sid;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
    *  Add a new supplier to the supplier table.
    */
    public function addSupplier($name, $num, $email)
    {
        $sql = "INSERT INTO supplier(name,phone, email)
                VALUES(:name, :num, :email)";

        $parameters = array(
            ':name' => $name,
            ':num' => $num,
            ':email' => $email
            );

        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }

    public function updateSupplier($sid, $supplier_name, $num, $mail)
    {
        $sql = "UPDATE supplier
                SET name = :supplier_name,
                    phone = :num,
                    email = :mail,
                WHERE sid = :sid;";

        $parameters = array(':supplier_name' => $name,
            ':num' => $phone,
            ':mail' => $email,
            ':sid' => $sid
        );
        $query = $this->db->prepare($sql);

        $query->execute($parameters);
    }

}
