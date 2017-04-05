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
        // create new "model" (and pass the database connection)
        $this->po = new PO($this->db);
        $this->project = new Project($this->db);
        $this->task = new Task($this->db);
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
