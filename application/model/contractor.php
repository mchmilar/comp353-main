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

    public function updateContractor($org_name, $first_name, $last_name, $phone, $profession, $cid)
    {
        $sql = "UPDATE contractor
                SET org_name = :org_name,
                    first_name = :first_name,
                    last_name = :last_name,
                    phone = :phone,
                    profession = :profession
                WHERE cid = :cid;";

        $parameters = array(':org_name' => $org_name,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':phone' => $phone,
            ':profession' => $profession,
            ':cid' => $cid
        );
        $query = $this->db->prepare($sql);

        $query->execute($parameters);
    }

    public function getContractorAddress($cid)
    {
        $sql = "SELECT cid, street, city, province,
                postal_code, house_num, country
                FROM contractor_address natural join address
                WHERE cid = $cid;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}
