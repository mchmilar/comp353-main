<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">
    <div id="task-subheader" class="col-md-10 col-md-offset-2">
        <form class="form-inline">
            <div class="form-group col-md-10 col-md-offset-1">
                <div class="form-group">
                    <input id="new-button" type="button" value="New" class="input-sm form-control">
                </div>
                <div class="form-group">
                    <input id="edit-po" type="button" value="Edit" class="input-sm form-control">
                    <input id="selected-po" value="0" type="hidden">
                </div>
            </div>
        </form>
    </div>
    <div id="new-po" class="col-md-12">
        <form class="form-inline ">
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Phase</span>
                        <select id="phase-id" class="input-sm form-control">
                            <?php foreach ($projects as $project) {
                                echo '<option value="' . $project->pid .'">'
                                    . $project->pid
                                    . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <input id="add-po-button" type="button" value="Create" class="form-control input-sm">
                </div>
            </div>
        </form>
    </div>
</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <div id="main-task-list" class="col-md-10 col-md-offset-1 content-box project-po">
        <table id="pos-table" class="table table-hover borderless">
            <thead>
            <tr>
                <th>PO ID</th>
                <th>Purchase Date</th>
                <th>Description</th>
                <th>Est. Delivery</th>
                <th>Act. Delivery</th>
                <th>Po Type</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pos as $po) { ?>
                <tr>
                    <td><?php echo $po->poid; ?></td>
                    <td><?php echo $po->purchase_date; ?></td>
                    <td><?php echo $po->description; ?></td> <!-- name is phase name -->
                    <td><?php echo $po->est_delivery; ?></td>
                    <td><?php echo $po->actual_delivery; ?></td>
                    <td><?php echo $po->po_type; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var url_with_index_file = "<?php echo URL_WITH_INDEX_FILE; ?>";
</script>