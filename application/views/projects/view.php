<?php
if (!$this)
{ exit(header('HTTP/1.0 403 Forbidden')); }
?>


<div id="subheader-content">
    <!-- Customer info -->
    <div class="col-md-3">
        <h6>Customer Name: <?php echo $customer->first_name . ' ' . $customer->last_name ?></h6>

    </div>

    <!-- Expected completion date -->
    <div class="col-md-3">
        <h6>Expected Completion Date: <?php echo date("F d, Y", strtotime($estimated_complete)) ?></h6>
    </div>

    <!-- Expected price -->
    <div class="col-md-2">
        <h6>Expected Price: <?php echo "$".$estimated_price ?></h6>
    </div>

    <!-- Budget info -->
    <div class="col-md-2">
        <h6 id="current-expenses">Current Expenses: <?php echo $price; ?></h6>
    </div>

    <!-- Current Phase -->
    <div class="col-md-2">
        <h6>Current Phase: <?php echo $phase; ?></h6>
    </div>
</div>

<div id="left-pane-content">
    <h5>Tasks</h5>
    <table id="tasks-table" class="table table-condensed borderless">
        <tbody>
            <tr class="task-row">
                <td class="tid-col hidden">0</td>
                <td class="task-name-col">All</td>
            </tr>
            <?php foreach ($tasks as $tsk) { ?>
                <tr class="task-row">
                    <td class="tid-col hidden"><?php echo $tsk->tid; ?></td>
                    <td class="task-name-col"><?php echo $tsk->description; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="right-pane-content">

    <!-- po list -->
    <div id="project-po-list" class="col-md-10 col-md-offset-1 content-box">
        <h5 class="po-content-label"><span class="task-name"></span> Purchase Orders</h5>
        <table id="quote-list-table" class="table">
            <thead>
            <tr>
                <th>PO ID</th>
                <th>Date</th>
                <th>Description</th>
                <th>Estimated Delivery</th>
                <th>Actual Delivery</th>
                <th>Total Cost</th>
            </tr>
            </thead>
            <tbody id="quote-list-table-body">

            </tbody>
        </table>
    </div>

    <div class="col-md-10 col-md-offset-1 content-box">
        <h5 class="po-content-label">Create <span class="task-name"></span> Purchase Order</h5>
        <form id="po-form" data-parsley-validate action="<?php echo URL_WITH_INDEX_FILE; ?>pos/addPO/<?php echo $pid ?>" method="POST">

            <!-- Type -->
            <div class="form-group">
                <div class="col-xs-2">
                    <label>Type</label>
                    <select id="po-type-select" name="po-type" class="form-control input-sm">
                        <option value="supply">Supply</option>
                        <option value="labour">Labour</option>
                        <option value="permit">Permit</option>
                    </select>
                </div>

                <!-- Task -->
                <div class="col-xs-2">
                    <label>Task</label>
                    <input id="task-desc-input" class="form-control input-sm po-task-type-textbox" type="text" name="task-description" value="Foundation" readonly>
                    <input id="hidden-task-id" type="hidden" name="task-id">
                </div>

                <!-- Est. Delivery -->
                <div class="col-xs-2">
                    <label>Est Delivery</label><input type="text" id="est-delivery" name="est-delivery" class="form-control input-sm">
                </div>

                <!-- PO Description -->
                <div class="col-xs-2">
                    <label>Description</label>
                    <input id="po-description" name="po-description" type="text" class="form-control input-sm">
                </div>
            </div>


            <!-- supply Line Items -->
            <div id="project-task-supply-po" class="invisible-panel">
                <div class="form-group">
                    <div class="col-xs-2">
                        <label>Supplier</label>
                        <select name="supplier" class="form-control input-sm">
                            <?php foreach ($suppliers as $supplier) {
                                echo '<option value="' . $supplier->name .'">'
                                    . $supplier->name
                                    . '</option>';
                            } ?>
                        </select>
                        <?php if(isset($_SESSION["addPoError"])) {
                            echo $_SESSION["addPoError"];
                            unset($_SESSION["addPoError"]);
                        } ?>
                    </div>
                </div>

                <table id="supply-po-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>MID</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody id="supply-po-table-body">
                        <tr>
                            <td><input name="mid-1" type="text" class="form-control input-sm"> </td>
                            <td><input name="description-1" type="text" class="form-control input-sm"> </td>
                            <td><input name="unit-price-1" type="text" class="form-control input-sm"> </td>
                            <td><input name="quantity-1" type="text" class="form-control input-sm"> </td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-group">
                    <input id="new-supply-row-button" type="button" value="New Line" class="form-control input-sm">
                </div>
                <div>

                </div>
            </div>

            <!-- labour Line Items -->
            <div id="project-task-labour-po" class="invisible-panel">
                <div class="form-group">
                    <div class="col-xs-4">
                        <label>Contractor</label>
                        <select name="contractor" class="form-control input-sm">
                            <?php foreach ($contractors as $contractor) {
                                echo '<option value="' . $contractor->org_name .'">'
                                    . $contractor->org_name
                                    . '</option>';
                            } ?>
                        </select>
                    </div>

                </div>
                <div>
                    <div id='labour-collapse' role='tabpanel' aria-labelledby='labour-heading'>
                        <table id="labour-po-table" class="table table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>Hours</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input name="description" type="text" class="form-control input-sm"> </td>
                                    <td><input name="rate" type="text" class="form-control input-sm"> </td>
                                    <td><input name="hours" type="text" class="form-control input-sm"> </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- permit Line Items -->
            <div id="project-task-permit-po" class="invisible-panel">
                <div class="form-group">
                    <div class="col-xs-4">
                        <label></label>
                        <select name="permit" class="form-control input-sm">
                            <?php foreach ($permits as $permit) {
                                echo '<option value="' . $permit->perm_num .'">'
                                    . $permit->name
                                    . '</option>';
                            } ?>
                        </select>
                    </div>

                </div>
                <div>
                    <div id='permit-collapse' role='tabpanel' aria-labelledby='permit-heading'>
                        <table id="permit-po-table" class="table table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Permit ID</th>
                                <th>Name</th>
                                <th>Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- submit -->
            <div class="form-group">
                <input type="submit" name="submit_add_project" value="Submit" />
            </div>
        </form>
    </div>
</div>
<script>
    var pid = "<?php echo $pid; ?>";
</script>