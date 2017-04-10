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

    public function getPO($poid) {
        $sql = "SELECT * FROM po where poid = :poid";
        $parameters = array(':poid' => $poid);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getAllPOs() {
        $sql = "SELECT * FROM po";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllProjectPOs($pid) {
        $sql = "SELECT * FROM po  where pid = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':pid' => $pid);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function addSupplyLine($poid, $sid, $mid, $desc, $uPrice, $qty) {
        $sql = "INSERT INTO supply
                VALUES (:poid, :mid, :sid, :desc, :ucost, :qty)";
        $query = $this->db->prepare($sql);
        $parameters = array(':poid' => $poid, ':mid' => $mid, ':sid' => $sid,
                            ':desc' => $desc,
                            ':ucost' => $uPrice, ':qty' => $qty);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        if (!$query->execute($parameters)) {
            throw new Exception('Add Supply Line Failed');
        }
    }

    public function addPermitLine($poid, $permitNum, $permitCost) {
        $sql = "INSERT INTO permitted
                VALUES (:poid, :perm_num, :cost)";
        $parameters = array(':poid' => $poid, ':perm_num' => $permitNum, ':cost' => $permitCost);
        $query = $this->db->prepare($sql);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);

    }

    public function addLabourLine($poid, $cid, $desc, $rate, $hours) {
        $sql = "INSERT INTO labour
                VALUES (:poid, :cid, :rate, :num_hours, :desc)";
        $query = $this->db->prepare($sql);
        $parameters = array(':poid' => $poid, ':cid' => $cid, ':num_hours' => $hours,
            ':desc' => $desc,
            ':rate' => $rate);
        $query->execute($parameters);
    }

    public function getPOsTaskProj($pid, $tid) {
        $sql = "SELECT poid, description, purchase_date, est_delivery, actual_delivery, po_type, cost 
                FROM po where tid = :tid and pid = :pid group by poid";
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

    public function createPO($poDesc, $estDelivery, $poType, $pid, $tid) {
        // get po id number to use
        $poid = $this->nextPOID();
        $today = date("Y-m-d");
        $sql = "INSERT INTO po (poid, purchase_date, description, est_delivery, po_type, pid, tid)
                VALUES (:poid, :purchase_date, :description, :est_delivery, :po_type, :pid, :tid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':purchase_date' => $today, ':description' => $poDesc, ':est_delivery' => $estDelivery, ':poid' => $poid, ':po_type' => $poType, ':pid' => $pid, ':tid' => $tid);
//        echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        if (!$query->execute($parameters)) {
            throw new Exception('Create PO Failed');
        }

        return $poid;
    }

    public function totalLabourCost($poid) {
        $sql = "SELECT rate, num_hours FROM labour WHERE poid = :poid";
        $query = $this->db->prepare($sql);
        $parameters = array(':poid' => $poid);
        $query->execute($parameters);
        $line = $query->fetch();

        return (double)$line->rate * (double)$line->num_hours;
    }

    public function totalSupplyCost($poid) {
        $sql = "SELECT unit_cost, qty FROM supply WHERE poid = :poid";
        $query = $this->db->prepare($sql);
        $parameters = array(':poid' => $poid);
        $query->execute($parameters);
        $lines = $query->fetchAll();

        $total = 0;
       // echo implode("|",$lines);exit();
        foreach ($lines as $line) {
           // echo $line; exit();
            $total += (double)$line->unit_cost * (double)$line->qty;
        }
        return $total;
    }

    public function nextPOID() {
        $sql = "SELECT max(poid) as poid FROM po";
        $query = $this->db->prepare($sql);
        $query->execute();
        $po = $query->fetch();
        return $po->poid +1;
    }

}
