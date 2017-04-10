<?php

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class POS extends Controller
{
    public function loadModel()
    {
        if(!isset($_SESSION['user_login_status']) OR $_SESSION['user_login_status'] != 1)
        {
            die(header('location: ' . URL_WITH_INDEX_FILE . 'login'));
        }
        require APP . '/model/po.php';
        require APP . '/model/project.php';
        require APP . '/model/task.php';
        require APP . '/model/supplier.php';
        require APP . '/model/contractor.php';
        // create new "model" (and pass the database connection)
        $this->po = new PO($this->db);
        $this->project = new Project($this->db);
        $this->task = new Task($this->db);
        $this->supplier = new Supplier($this->db);
        $this->contractor = new Contractor($this->db);
    }

    public function makePayment($poid) {
        $amount = $_POST['payment'];
        $this->po->pay($poid, $amount);

        $this->edit($poid);
    }

    public function edit($poid) {
        $po = $this->po->getPO($poid);
        $payments = $this->po->getPayments($poid);
        if ($po->po_type === 'supply') {
            $supplyLines = $this->po->getSupplyLines($poid);
        }

        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/body.php';
        require APP . 'views/pos/edit.php';
        require APP . 'views/_templates/footer.php';
    }

    public function index() {
        $pos = $this->po->getAllPOs();
        $projects = $this->project->getAllProjects();

        require APP . 'views/_templates/header.php';
        require APP . 'views/_templates/body.php';
        require APP . 'views/pos/index.php';
        require APP . 'views/_templates/footer.php';
    }

    public function addPO($pid) {
        $taskId = $_POST['task-id'];
        $estDelivery = $_POST['est-delivery'];
        $poDesc = $_POST['po-description'];
        $poType = $_POST['po-type'];
        $taskDesc = $_POST['task-description'];
        $hasDesc = $poType === 'labour' || $poType === 'supply';

        // Check for incomplete PO
        // If it is, die with error
        if ($taskId == null || $estDelivery == null ||($hasDesc && $poDesc == null)) {
//            echo ("here");die();
            $_SESSION["addPoError"] = "Incomplete PO";
            die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
        }

        // unset the already used _POST key/value pairs
        unset($_POST['task-id'], $_POST['est-delivery'], $_POST['po-description'], $_POST['task-description'], $_POST['po-type']);

        if ($poType === 'supply') {
            $supplier = $_POST['supplier'];
            unset($_POST['supplier']);

            // Turn POST members into indexed array
            $indexed_post = array_values($_POST);
            $lineItems = $this->validateLineItems($indexed_post, 4, $pid);

            /////////////////////////////////////////////////////
            // We have verified our input data, perform inserts//
            /////////////////////////////////////////////////////
            $this->db->beginTransaction();
            try {// Create PO and get its id
                $poid = $this->po->createPO($poDesc, $estDelivery, $poType, $pid, $taskId);

                // Insert each line item into supply
                $sid = $this->supplier->getSupplierIdFromName($supplier);
                foreach ($lineItems as $line) {
                    $this->po->addSupplyLine($poid, $sid, $line[0], $line[1], $line[2], $line[3]);
                }
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION["addPoError"] = $e->getMessage();
                die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
            }
            $this->db->commit();
        } elseif ($poType === 'labour') {
            $contractor = $_POST['contractor'];
            unset($_POST['contractor']);

            // Turn POST members into indexed array
            $indexed_post = array_values($_POST);
            $lineItems = $this->validateLineItems($indexed_post, 3, $pid);

            /////////////////////////////////////////////////////
            // We have verified our input data, perform inserts//
            /////////////////////////////////////////////////////

            // Create PO and get its id
            $this->db->beginTransaction();
            try {
                $poid = $this->po->createPO($poDesc, $estDelivery, $poType, $pid, $taskId);

                // Insert each line item into supply
                $sid = $this->contractor->getContractorIdFromName($contractor);
                foreach ($lineItems as $line) {
                    $this->po->addLabourLine($poid, $sid,  $line[0], $line[1], $line[2]);
                }
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION["addPoError"] = $e->getMessage();
                die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
            }
            $this->db->commit();
        } else {
            $permitCost = $_POST['permit-cost'];
            $permitNum = $_POST['permit-num'];
            $permitName = $_POST['permit-name'];
            // Create PO and get its id
            $this->db->beginTransaction();
            try {
                $poid = $this->po->createPO($permitName, $estDelivery, $poType, $pid, $taskId);

                // Insert each line item into supply
                $sid = $this->po->addPermitLine($poid, $permitNum, $permitCost);
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION["addPoError"] = $e->getMessage();
                die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
            }
            $this->db->commit();
        }
        header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid);
    }

    private function validateLineItems($indexed_post, $items_per_line, $pid) {
        $lineItems = array();

        // Put each line item into its own array, nested in the lineItems array
        // We also check for line completeness
        // If all parts of the line are empty and it's not we ignore the line and move on
        // If some items are empty, die with error
        //
        // TODO: Data validation in here?
        for ($i = 0; $i < count($indexed_post) - ($items_per_line - 1); $i += $items_per_line) {
            $nullCount = 0;
            for ($j = $i; $j < $i + $items_per_line; $j++) {
                if ($indexed_post[$j] == null) $nullCount++;
            }

            if ($nullCount == $items_per_line) {
                continue;
            } elseif ($nullCount > 0 && $nullCount < $items_per_line) {
                // Die with error
                $_SESSION["addPoError"] = "Incomplete PO";
                die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
            }
            $line = array();
            for ($j = $i; $j < $i + $items_per_line; $j++) {
                array_push($line, $indexed_post[$j]);
            }
            array_push($lineItems, $line);
        }
        return $lineItems;
    }


    public function ajaxPOsTaskProj($pid, $tid) {
        //echo $pid;
        //echo $tid;
        $table = "";
        if (isset($pid, $tid)) {

            if ($tid == 0) {
                // get all po's
                $pos = $this->po->getAllProjectPOs($pid);
            } else {
                // get po's for specified task
                $pos = $this->po->getPOsTaskProj($pid, $tid, "supply");
//                $labour_pos = $this->po->getPOsTaskProj($pid, $tid, "labour");
//                $pos = array_merge($supply_pos, $labour_pos);
            }

            foreach($pos as $po) {
                $table .= "<tr>";
                $table .= "<td>" . $po->poid . "</td>";
                $table .= "<td>" . $po->purchase_date . "</td>";
                $table .= "<td>" . $po->description . "</td>";
                $table .= "<td>" . $po->est_delivery . "</td>";
                $table .= "<td>" . $po->actual_delivery . "</td>";
                $total_cost = $po->cost;
                $table .= "<td>" . $total_cost . "</td>";
                $table .= "</tr>";
            }
        } else {
            $table .= "<tr>nothing</tr>";
        }

        echo $table;
    }

}
