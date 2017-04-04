<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <!-- add project form -->
    <div>
        <h3>Add a project</h3>
        <form data-parsley-validate action="<?php echo URL_WITH_INDEX_FILE; ?>projects/addproject" method="POST">
            <label>Price</label>
            <input data-parsley-dollars type="text" name="price" value="" required />
            <label>Name</label>
            <select name="name">
                <?php foreach ($customers as $customer) {
                    echo '<option value="' . $customer->first_name . ' '. $customer->last_name .'">'
                        . $customer->first_name . ' '. $customer->last_name
                        . '</option>';
                } ?>
            </select>
            <label>Link</label>

            <input type="submit" name="submit_add_project" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div>

        <h3>List of projects</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Project ID</td>
                <td>Project Price</td>
                <td>Customer First Name</td>
                <td>Customer Last Name</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project) { ?>
                <tr>
                    <td><?php if (isset($project->pid)) echo htmlspecialchars($project->pid, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($project->price)) echo htmlspecialchars($project->price, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($project->first_name)) echo htmlspecialchars($project->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($project->last_name)) echo htmlspecialchars($project->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
