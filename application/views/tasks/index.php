<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">
    <div id="task-subheader" class="col-md-10 col-md-offset-2">
        <form class="form-inline">
            <div class="form-group col-md-10 col-md-offset-1">
                <div class="form-group">
                    <input id="new-button" type="button" value="New" class="input-sm form-control">
                </div>
                <div class="form-group">
                    <input id="edit-task" type="button" value="Edit" class="input-sm form-control">
                    <input id="selected-task" value="0" type="hidden">
                </div>
            </div>
        </form>
    </div>
    <div id="new-task" class="col-md-12">
        <form class="form-inline "  action="<?php echo URL_WITH_INDEX_FILE; ?>tasks/addTask" method="POST">
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Description</span>
                        <input name="description" type="text" class="input-sm form-control">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Phase</span>
                        <select name="phase" class="input-sm form-control">
                            <?php foreach ($phases as $phase) {
                                echo '<option value="' . $phase->phase_id .'">'
                                    . $phase->name
                                    . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Cost Factor</span>
                        <input name="cfactor" type="text" class="input-sm form-control">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <input type="button" value="Cancel" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Cost Base</span>
                        <input name="cbase" type="text" class="input-sm form-control">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Time Factor</span>
                        <input name="tfactor" type="text" class="input-sm form-control">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Time Base</span>
                        <input name="tbase" type="text" class="input-sm form-control">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <input name="submit_add_task" type="submit" value="Create" class="form-control input-sm">
                </div>
            </div>
        </form>
    </div>
</div>

<div id="left-pane-content">
    <form action="<?php echo URL_WITH_INDEX_FILE; ?>tasks" method="POST">
        <div class="row">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Description</label>
                    <input name="description" type="text" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Phase</label>
                    <select name="phase" class="form-control input-sm">
                        <option value="0">All</option>
                        <?php foreach ($phases as $phase) {
                            echo '<option value="' . $phase->phase_id .'">'
                                . $phase->name
                                . '</option>';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Cost Factor</label>
                    <select name="cost-factor-condition" class="form-control input-sm">
                        <option value="greater-or-equal" class="form-control input-sm">greater or equal</option>
                        <option value="less-or-equal" class="form-control input-sm">less or equal</option>
                        <option value="greater-than" class="form-control input-sm">greather than</option>
                        <option value="less-than" class="form-control input-sm">less than</option>
                    </select>
                    <input name="cost-factor" type="text" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Cost Base</label>
                    <select name="cost-base-condition" class="form-control input-sm">
                        <option value="greater-or-equal" class="form-control input-sm">greater or equal</option>
                        <option value="less-or-equal" class="form-control input-sm">less or equal</option>
                        <option value="greater-than" class="form-control input-sm">greather than</option>
                        <option value="less-than" class="form-control input-sm">less than</option>
                        <option value="equal" class="form-control input-sm">equal</option>
                    </select>
                    <input name="cost-base" type="text" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Time Factor</label>
                    <select name="time-factor-condition" class="form-control input-sm">
                        <option value="greater-or-equal" class="form-control input-sm">greater or equal</option>
                        <option value="less-or-equal" class="form-control input-sm">less or equal</option>
                        <option value="greater-than" class="form-control input-sm">greather than</option>
                        <option value="less-than" class="form-control input-sm">less than</option>
                        <option value="equal" class="form-control input-sm">equal</option>
                    </select>
                    <input name="time-factor" type="text" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Time Base</label>
                    <select name="time-base-condition" class="form-control input-sm">
                        <option value="greater-or-equal" class="form-control input-sm">greater or equal</option>
                        <option value="less-or-equal" class="form-control input-sm">less or equal</option>
                        <option value="greater-than" class="form-control input-sm">greather than</option>
                        <option value="less-than" class="form-control input-sm">less than</option>
                        <option value="equal" class="form-control input-sm">equal</option>
                    </select>
                    <input name="time-base" type="text" class="form-control input-sm">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <input type="submit" name="submit_task_filter" value="Submit" />
                </div>
            </div>
        </div>

    </form>
</div>

<div id="right-pane-content">
    <div id="main-task-list" class="col-md-10 col-md-offset-1 content-box project-po">
        <table id="tasks-table" class="table table-hover borderless">
            <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Description</th>
                <th>Phase</th>
                <th>Cost Factor</th>
                <th>Cost Base</th>
                <th>Time Factor</th>
                <th>Time Base</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr>
                    <td><?php echo $task->tid; ?></td>
                    <td><?php echo $task->description; ?></td>
                    <td><?php echo $task->name; ?></td> <!-- name is phase name -->
                    <td><?php echo $task->cost_per_sq_foot; ?></td>
                    <td><?php echo $task->base_cost; ?></td>
                    <td><?php echo $task->time_per_sq_foot; ?></td>
                    <td><?php echo $task->base_time; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    var url_with_index_file = "<?php echo URL_WITH_INDEX_FILE; ?>";
</script>