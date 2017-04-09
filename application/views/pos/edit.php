<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">

</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <form class="form-inline" action="<?php echo URL_WITH_INDEX_FILE; ?>pos/updateTask/<?php echo $task->tid; ?>" method="POST">
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
                <input name="actual-delivery" type="text" class="input-sm form-control"  value="<?php echo $po->actual_delivery; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">PO Type</span>
                <input disabled name="po-type" type="text" class="input-sm form-control"  value="<?php echo $po->po_type; ?>">
            </div>
            <div class="form-group col-md-3">
                <input name="submit_update_task" type="submit" value="Update" class="form-control input-sm">
            </div>
        </div>
        <div class="form-group">
            <?php if ($po->po_type === 'supply') require APP . 'views/pos/supply.php'; ?>
        </div>
    </form>
</div>