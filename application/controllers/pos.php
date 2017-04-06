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
        require APP . '/model/po.php';
        require APP . '/model/project.php';
        require APP . '/model/task.php';
        require APP . '/model/supplier.php';
        // create new "model" (and pass the database connection)
        $this->po = new PO($this->db);
        $this->project = new Project($this->db);
        $this->task = new Task($this->db);
        $this->supplier = new Supplier($this->db);
    }

    public function addPO($pid) {
        $taskId = $_POST['task-id'];
        $estDelivery = $_POST['est-delivery'];
        $poDesc = $_POST['po-description'];
        $poType = $_POST['po-type'];
        $taskDesc = $_POST['task-description'];

        // Check for incomplete PO
        // If it is, die with error
        if ($taskId == null || $estDelivery == null || $poDesc == null) {
            $_SESSION["addPoError"] = "Incomplete PO";
            die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
        }

        // unset the already used _POST key/value pairs
        unset($_POST['task-id'], $_POST['est-delivery'], $_POST['po-description'], $_POST['task-description'], $_POST['po-type']);

        if ($poType === 'material') {
            // create 2x2 array of line item info
            $supplier = $_POST['supplier'];
            unset($_POST['supplier']);

            // Turn POST members into indexed array
            $indexed_post = array_values($_POST);

            $lineItems = array();

            // Put each line item into its own array, nested in the lineItems array
            // We also check for line completeness
            // If all parts of the line are empty and it's not we ignore the line and move on
            // If some items are empty, die with error
            //
            // TODO: Data validation in here?
            for ($i = 0; $i < count($indexed_post) - 3; $i += 4) {
                $nullCount = 0;
                if ($indexed_post[$i] == null) $nullCount++;
                if ($indexed_post[$i+1] == null) $nullCount++;
                if ($indexed_post[$i+2] == null) $nullCount++;
                if ($indexed_post[$i+3] == null) $nullCount++;

                if ($nullCount == 4) {
                    continue;
                } elseif ($nullCount > 0 && $nullCount < 4) {
                    // Die with error
                    $_SESSION["addPoError"] = "Incomplete PO";
                    die(header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid));
                }

                array_push($lineItems, array(
                    'mid' => $indexed_post[$i],
                    'description' => $indexed_post[$i+1],
                    'price' => $indexed_post[$i+2],
                    'qty' => $indexed_post[$i+3]));
            }

            /////////////////////////////////////////////////////
            // We have verified our input data, perform inserts//
            /////////////////////////////////////////////////////

            // Create PO and get its id
            $poid = $this->po->createPO($poDesc, $estDelivery);

            // Insert each line item into supply
            $sid = $this->supplier->getSupplierIdFromName($supplier);
            foreach ($lineItems as $line) {
                $this->po->addSupplyLine($poid, $sid, $taskId, $pid, $line['mid'], $line['description'], $line['price'], $line['qty']);
            }
        }
        header('location: ' . URL_WITH_INDEX_FILE . 'projects/view/' . $pid);
    }


    public function ajaxPOsTaskProj($pid, $tid) {
        //echo $pid;
        //echo $tid;
        $table = "";
        if (isset($pid, $tid)) {
            $pos = $this->po->getPOsTaskProj($pid, $tid);
            foreach($pos as $po) {
                $table .= "<tr>";
                $table .= "<td>" . $po->poid . "</td>";
                $table .= "<td>" . $po->purchase_date . "</td>";
                $table .= "<td>" . $po->description . "</td>";
                $table .= "<td>" . $po->est_delivery . "</td>";
                $table .= "<td>" . $po->actual_delivery . "</td>";
                $table .= "</tr>";
            }
        } else {
            $table .= "<tr>nothing</tr>";
        }

        echo $table;
    }

}
