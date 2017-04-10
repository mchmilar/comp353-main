<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">

</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <form class="form" action="<?php echo URL_WITH_INDEX_FILE; ?>pos/updateTask/<?php echo $task->tid; ?>" method="POST">
        <div class="form-group">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Description</span>
                    <input name="description" type="text" class="input-sm form-control" value="<?php echo $po->description; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Purchase Date</span>
                    <input id="po-edit-purchase-date" disabled type="text" value="<?php echo $po->purchase_date; ?>" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Est. Delivery</span>
                    <input id="po-edit-est-delivery" type="text" class="input-sm form-control" value="<?php echo $po->est_delivery; ?>">
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">Act. Delivery</span>
                <input id="po-edit-actual-delivery" name="actual-delivery" type="text" class="input-sm form-control"  value="<?php echo $po->actual_delivery; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">PO Type</span>
                <input disabled name="po-type" type="text" class="input-sm form-control"  value="<?php echo $po->po_type; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Owed</span>
                <input disabled name="owed" type="text" class="input-sm form-control"  value="<?php echo $po->cost - $po->paid; ?>">
            </div>
            <div class="form-group col-md-3">
                <input name="submit_update_task" type="submit" value="Update" class="form-control input-sm">
            </div>
        </div>
        <div class="form-group">
            <?php if ($po->po_type === 'supply') require APP . 'views/pos/supply.php'; ?>
        </div>
    </form>

    <form data-parsley-validate class="form" action="<?php echo URL_WITH_INDEX_FILE; ?>pos/makePayment/<?php echo $poid; ?>" method="POST">
        <div class="input-group">
            <span class="input-group-addon">Payment Amount</span>
            <input name="payment" type="text" class="input-sm form-control"  value="0">
        </div>
        <div class="form-group col-md-3">
            <input data-parseley-validate name="submit_payment" type="submit" value="Pay" class="form-control input-sm">
        </div>
    </form>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Number</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($payments as $payment) {
                echo "<tr>" .
                    "<td>$payment->num</td>" .
                    "<td>$payment->amount</td>" .
                    "<td>$payment->date</td>" .
                    "</tr>";
            }

            ?>
            </tbody>
        </table>
    </div>
</div>