<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden'))
; } ?>

<div id="subheader-content">

</div>

<div id="left-pane-content">

</div>

<div id="right-pane-content">
    <form action="<?php echo URL_WITH_INDEX_FILE;?>contractors/updateContractor/<?php echo $selectedContractor->cid;?>" method="POST">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Organization Name</span>
                <input name="org_name" type="text" class="input-sm form-control" value="<?php echo $selectedContractor->org_name;?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">First Name</span>
                <input name="first_name" type = "text" class="input-sm form-control" value="<?php echo $selectedContractor->first_name;?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Last Name</span>
                <input name="last_name" type="text" class="input-sm form-control" value="<?php echo $selectedContractor->last_name; ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Phone</span>
                <input name="phone" type="text" class="input-sm form-control" value="<?php echo $selectedContractor->phone;?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Profession</span>
                <input name="profession" type="text" class="input-sm form-control" value="<?php echo $selectedContractor->profession; ?>">
            </div>
            <div class="form-group col-md-3">
                <input id="submit_update_contractor" name="submit_update_contractor" type="submit" value="Update" class="form-control input-sm">
            </div>
        </div>
    </form>
</div>

<script>
    var url_with_index_file = "<?php echo URL_WITH_INDEX_FILE; ?>";
</script>