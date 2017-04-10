<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden'))
; } ?>
<!-- Start of subheader content -->
<div id="subheader-content">
	<div id="contractor-subheader" class="col-md-10 col-md-offset-2">
        <form class="form-inline">
            <div class="form-group col-md-10 col-md-offset-1">
                <div class="form-group">
                    <input id="new-button" type="button" value="New" class="input-sm form-control">
                </div>
                <div class="form-group">
                    <input id="edit-contractor" type="button" value="Edit" class="input-sm form-control">
                    <input id="selected-contractor" value="0" type="hidden">
                </div>
            </div>
        </form>
    </div>
    <div id="new-contractor" class="col-md-12">
        <form data-parsley-validate="" class="form-inline" action="<?php echo URL_WITH_INDEX_FILE; ?>contractors/addContractor" method="POST">
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Organization Name</span>
                        <input name="org_name" type="text" class="input-sm form-control"
                        data-parsley-name="">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">First Name</span>
                        <input name= "first_name" type="text"
                        class="input-sm form-control"
                        data-parsley-name="">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Last Name</span>
                        <input name= "last_name" type="text"
                        class="input-sm form-control"
                        data-parsley-name="">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Phone Number</span>
                        <input name="phone" type="text" class="input-sm form-control"
                        data-parsley-pattern="/\d-\(\d{3}\)\d{3}-\d{4}/">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Profession</span>
                        <input name= "profession" type="text"
                        class="input-sm form-control"
                        data-parsley-name="">
                    </div>
                </div> 
                <div class= "form-group col-md-3">
                	<input name="submit_add_contractor" type= "submit" value = "Create" class = "form-control input-sm">
                </div>
            </div>
        </form>
    </div>
</div>

<div id="right-pane-content">
	<div id="main-contractors-list" class="col-md-10 col-md-offset-1 content-box project-po">
		<table id = "contractors-table" class="table table-hover borderless">
			<thead>
				<tr>
					<th>Contractor ID</th>
					<th>Organization Name</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Phone Number</th>
					<th>Profession</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Province</th>
                    <th>Postal Code</th>
                    <th>Civic Number</th>
                    <th>Country</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contractors as $contractor){?>
					<tr>
						<td><?php echo $contractor->cid?></td>
						<td><?php echo $contractor->org_name?></td>
						<td><?php echo $contractor->first_name?></td>
						<td><?php echo $contractor->last_name?></td>
						<td><?php echo $contractor->phone?></td>
						<td><?php echo $contractor->profession?>
                        </td>
                        <?php 
                             $addresses = $contractorPointer->getContractorAddress($contractor->cid);
                        ?>
                        <td>
                            <?php echo $addresses[0]->street?>
                        </td>

                        <td>
                            <?php echo $addresses[0]->city?>
                        </td>

                        <td>
                            <?php echo $addresses[0]->province?>
                        </td>

                        <td>
                            <?php echo $addresses[0]->postal_code?>
                        </td>

                        <td>
                            <?php echo $addresses[0]->house_num?>
                        </td>
                        <td>
                            <?php echo $addresses[0]->country?>
                        </td>
					</tr>
				<?php	
				}
				?>
			</tbody>
		</table>
	</div>

</div>

<script>
    var url_with_index_file = "<?php echo URL_WITH_INDEX_FILE; ?>";
</script>

