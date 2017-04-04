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
                    <tr class="clickable-row" >
                        <td><?php echo $tsk->tid; ?></td>
                        <td><?php echo $tsk->description; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Create PO for selected task -->
        <div class="col-sm-6">
            
        </div>

    </div>


</div>
