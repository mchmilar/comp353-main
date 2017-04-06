<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">

    <!-- Customer info -->
    <div>
        <h2>Customer Name: <?php echo $customer->first_name . ' ' . $customer->last_name ?></h2>

    </div>

    <!-- Expected completion date -->
    <div>
        <h2>Expected Completion Date:</h2>
    </div>

    <!-- Budget info -->
    <div>
        <h2></h2>
    </div>

    <!-- Current Phase -->
    <div>
        <h2>Current Phase: </h2>
    </div>

    <!-- Tasks -->
    <div class="row">
        <!-- task list table -->
        <div class="col-sm-6">
            <h2>Tasks:</h2>
            <table id="tasks-table" class="display">
                <thead>
                <tr>
                    <td>Task ID</td>
                    <td>Description</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $tsk) { ?>
                    <tr class="task-row">
                        <td class="tid-col"><?php echo $tsk->tid; ?></td>
                        <td class="task-name-col"><?php echo $tsk->description; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="col-sm-6">
            <!-- Display current PO's for selected task -->
            <div class="row" id="quote-list">
                <div class="col-sm-12">
                    <table id="quote-list-table" class="table table-striped table-condensed">
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
            </div>

            <!-- Create PO for selected task -->
            <div class="row" id="quote-builder">
                    <form id="po-form" data-parsley-validate action="<?php echo URL_WITH_INDEX_FILE; ?>pos/addPO/<?php echo $pid ?>" method="POST">

                        <!-- Type -->
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label>PO Type</label>
                                <select id="po-type-select" name="po-type" class="form-control">
                                    <option value="material">Material</option>
                                    <option value="labour">Labour</option>
                                </select>
                            </div>

                            <!-- Task -->
                            <div class="col-xs-3">
                                <label>Task</label>
                                <input id="task-desc-input" class="form-control po-task-type-textbox" type="text" name="task-description" value="Foundation" readonly>
                                <input id="hidden-task-id" type="hidden" name="task-id">
                            </div>

                            <!-- Est. Delivery -->
                            <div class="col-xs-3">
                                <label>Est Delivery</label><input type="text" id="est-delivery" name="est-delivery" class="form-control">
                            </div>

                            <!-- PO Description -->
                            <div class="col-xs-3">
                                <label>PO Description</label>
                                <input id="po-description" name="po-description" type="text" class="form-control">
                            </div>
                        </div>


                        <!-- Material Line Items -->
                        <div id="project-task-material-po" class="invisible-panel">
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Supplier</label>
                                    <select name="supplier" class="form-control">
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

                                <table id="material-po-table" class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>MID</th>
                                        <th>Description</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody id="material-po-table-body">
                                    <tr>
                                        <td class="col-xs-2"><input name="mid" type="text" class="form-control"> </td>
                                        <td><input name="description" type="text" class="form-control"> </td>
                                        <td><input name="unit-price" type="text" class="form-control"> </td>
                                        <td><input name="quantity" type="text" class="form-control"> </td>
                                    </tr>
                                    </tbody>
                                </table>

                            <div>

                            </div>
                        </div>

                        <!-- Contractor Line Items -->
                        <div id="project-task-contractor-po" class="invisible-panel">
                            <div>
                                <label>Contractor</label>
                                <select name="contractor">
                                    <?php foreach ($contractors as $contractor) {
                                        echo '<option value="' . $contractor->org_name .'">'
                                            . $contractor->org_name
                                            . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div>
                                <div id='contractor-collapse' role='tabpanel' aria-labelledby='contractor-heading'>
                                    <table id="material-po-table" class="table table-striped table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Rate</th>
                                            <th>Hours</th>
                                        </tr>
                                        </thead>
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

    </div>


</div>

<script>
    var pid = "<?php echo $pid; ?>";
</script>