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
                    <tr >
                        <td><?php echo $tsk->tid; ?></td>
                        <td><?php echo $tsk->description; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Create PO for selected task -->
        <div class="col-sm-6">
            <div class="row" id="quote-list">
                AAAAA
            </div>
            <div class="row" id="quote-builder">
                <form data-parsley-validate action="<?php echo URL_WITH_INDEX_FILE; ?>quotes/addquote" method="POST">
                    <label>Purchase Order Type</label>
                    <select id="po-type-select" name="po-type">
                        <option value="material">Material</option>
                        <option value="labour">Labour</option>
                    </select>
                    <input type="submit" name="submit_add_project" value="Submit" />

                    <!-- Material PO -->
                    <div id="project-task-material-po" class="panel panel-default po-content invisible-panel">
                        <div class="panel-heading">
                            <label>Supplier</label>
                            <select name="supplier">
                                <?php foreach ($suppliers as $supplier) {
                                    echo '<option value="' . $supplier->name .'">'
                                        . $supplier->name
                                        . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="panel-body">
                            <div id='material-collapse' role='tabpanel' aria-labelledby='material-heading'>
                                <table id="material-po-table" class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Contractor PO -->
                    <div id="project-task-contractor-po" class="panel panel-default po-content invisible-panel">
                        <div class="panel-heading">
                            <label>Contractor</label>
                            <select name="contractor">
                                <?php foreach ($contractors as $contractor) {
                                    echo '<option value="' . $contractor->org_name .'">'
                                        . $contractor->org_name
                                        . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="panel-body">
                            <div id='contractor-collapse' role='tabpanel' aria-labelledby='contractor-heading'>
                                <table id="material-po-table" class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


</div>
