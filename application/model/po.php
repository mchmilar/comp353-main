<?php

class PO
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

    /**
     * Get all songs from database
     */
    public function getPOsTaskProj($pid, $tid) {
        $sql = "SELECT po.poid, po.description, purchase_date, est_delivery, actual_delivery FROM po, supply where tid = :tid and pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid, ':tid' => $tid);
        $query->execute($parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

}
