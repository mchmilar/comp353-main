<?php
if (!$this)
{ exit(header('HTTP/1.0 403 Forbidden')); }
?>
<div id="left-pane-content">
        <h3>Employees</h3>
</div>
<div id="right-pane-content">
    <div id="main-employees-list" class="col-md-10 col-md-offset-1 content-box project-po">
        <table id="employee_list" class="table table-hover ">
            <thead>
                <th>UID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee){?>
                    <tr>
                        <td><?php echo $employee->uid; ?></td>
                        <td><?php echo $employee->first_name; ?></td>
                        <td><?php echo $employee->last_name; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>