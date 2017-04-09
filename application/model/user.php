<?php

class User
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

    //checks that user id is valid
    public function checkUser($uid) {
        $sql = "SELECT * 
                FROM user 
                WHERE uid = $uid";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    //checks that password for a particular user id is valid
    public function checkPassword($uid, $password) {
        $sql = "SELECT * 
                FROM user 
                WHERE uid = :uid and password = :password";
        $parameters = array(':uid' => $uid, ':password' => $password);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }

    //checks the access for a user
    public function checkAccess($uid) {
        $sql = "SELECT access_level 
                FROM user 
                WHERE uid = :uid;";
        $parameters = array(':uid' => $uid);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }

    //checks what projects are available for a user
    public function checkProjects($uid) {
        $sql = "SELECT pid 
                FROM purchase_project 
                WHERE uid = :uid;";
        $parameters = array(':uid' => $uid);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll();
    }

}