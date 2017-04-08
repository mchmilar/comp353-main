<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">

</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <form action="<?php echo URL_WITH_INDEX_FILE; ?>tasks/updateTask/<?php echo $task->tid; ?>" method="POST">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Description</span>
                <input name="description" type="text" class="input-sm form-control" value="<?php echo $task->description; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Phase</span>
                <select name="phase" class="input-sm form-control">
                    <?php foreach ($phases as $phase) {
                        echo '<option ' .  (($phase->phase_id == $task->phase_id) ? "selected" : "") . ' value="' . $phase->phase_id . '">'
                            . $phase->name
                            . '</option>';
                    } ?>
                </select>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Cost Factor</span>
                <input name="cfactor" type="text" class="input-sm form-control" value="<?php echo $task->cost_per_sq_foot; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Cost Base</span>
                <input name="cbase" type="text" class="input-sm form-control"  value="<?php echo $task->base_cost; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Time Factor</span>
                <input name="tfactor" type="text" class="input-sm form-control"  value="<?php echo $task->time_per_sq_foot; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Time Base</span>
                <input name="tbase" type="text" class="input-sm form-control"  value="<?php echo $task->base_time; ?>">
            </div>
            <div class="form-group col-md-3">
                <input name="submit_update_task" type="submit" value="Update" class="form-control input-sm">
            </div>
        </div>
    </form>
</div>