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

    public function addSupplyLine($poid, $sid, $tid, $pid, $mid, $desc, $uPrice, $qty) {
        $sql = "INSERT INTO supply
                VALUES (:poid, :mid, :sid, :tid, :pid, :desc, :ucost, :qty)";
        $query = $this->db->prepare($sql);
        $parameters = array(':poid' => $poid, ':mid' => $mid, ':sid' => $sid,
                            ':tid' => $tid, ':pid' => $pid, ':desc' => $desc,
                            ':ucost' => $uPrice, ':qty' => $qty);
        $query->execute($parameters);
    }

    public function getPOsTaskProj($pid, $tid) {
        $sql = "SELECT po.poid, po.description, purchase_date, est_delivery, actual_delivery FROM po, supply where po.poid = supply.poid and tid = :tid and pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid, ':tid' => $tid);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function createPO($poDesc, $estDelivery) {
        // get po id number to use
        $poid = $this->nextPOID();
        $today = date("Y-m-d");
        $sql = "INSERT INTO po (poid, purchase_date, description, est_delivery)
                VALUES (:poid, :purchase_date, :description, :est_delivery)";
        $query = $this->db->prepare($sql);
        $parameters = array(':purchase_date' => $today, ':description' => $poDesc, ':est_delivery' => $estDelivery, ':poid' => $poid);
     //   echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);

        return $poid;
    }

    public function nextPOID() {
        $sql = "SELECT max(poid) as poid FROM po";
        $query = $this->db->prepare($sql);
        $query->execute();
        $po = $query->fetch();
        return $po->poid +1;
    }

}
