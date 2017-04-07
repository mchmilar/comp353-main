<?php

/**
 * Created by PhpStorm.
 * User: justinwhatley
 * Date: 2017-04-07
 * Time: 3:19 PM
 */
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
                WHERE uid = $uid and password = $password";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

}