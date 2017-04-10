<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div id="subheader-content">

</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <form action="<?php echo URL_WITH_INDEX_FILE;?>supplier/updateSupplier/<?php echo $selected_supplier->sid;?>" method="POST" data-parsley-validate>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Supplier Name</span>
                <input id="name" name="name" type="text" class="input-sm form-control" value="<?php echo $selected_supplier->name;?>"
                >
            </div>
            <div class="input-group">
                <span class="input-group-addon">Phone</span>
                <input name="phone_number" type = "text" class="input-sm form-control" value="<?php echo $selected_supplier->phone;?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Email</span>
                <input id="email" name="email" type="text" class="input-sm form-control" value="<?php echo $selected_supplier->email; ?>">
            </div>
            <div class="form-group col-md-3">
                <input name="submit_update_task" type="submit" value="Update" class="form-control input-sm">
            </div>
        </div>
    </form>
</div>