<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden'))
; } ?>

<!-- Start of subheader content -->
<div id="subheader-content">
	<div id="supplier-subheader" class="col-md-10 col-md-offset-2">
        <form class="form-inline">
            <div class="form-group col-md-10 col-md-offset-1">
                <div class="form-group">
                    <input id="new-button" type="button" value="New" class="input-sm form-control">
                </div>
                <div class="form-group">
                    <input id="edit-task" type="button" value="Edit" class="input-sm form-control">
                    <input id="selected-supplier" value="0" type="hidden">
                </div>
            </div>
        </form>
    </div>
    <div id="new-supplier" class="col-md-12">
        <form data-parsley-validate="" class="form-inline" action="<?php echo URL_WITH_INDEX_FILE; ?>suppliers/addSupplier" method="POST">
            <div class="form-group col-md-12">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Supplier Name</span>
                        <input name="supplier_name" type="text" class="input-sm form-control"
                         data-parsley-type="alphanum"data-parsley-maxlength="45" required="">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Phone Number</span>
                        <input name= "phone_number" type="text"
                        class="input-sm form-control"
                        data-parsley-pattern="/\d-\(\d{3}\)\d{3}-\d{4}/" required="">
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">Email</span>
                        <input name="email" type="text" class="input-sm form-control" data-parsley-type="email">
                    </div>
                </div> 
                <div class= "form-group col-md-3">
                	<input name="submit_add_supplier" type= "submit" value = "Create" class = "form-control input-sm">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Start of left pane content -->
<div id="left-pane-content">

</div>

<div id="right-pane-content">
	<div id="main-suppliers-list" class="col-md-10 col-md-offset-1 content-box project-po">
		<table id = "suppliers-table" class = "table table-hover borderless">
			<thead>
				<tr>
					<th>Supplier ID</th>
					<th>Supplier Name</th>
					<th>Phone Number</th>
					<th>Email</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Province</th>
                    <th>Postal Code</th>
                    <th>Civic Number</th>
                    <th>Country</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($suppliers as $supplier){?>
					<tr>
						<td><?php echo $supplier->sid?></td>
						<td><?php echo $supplier->name?></td>
						<td><?php echo $supplier->phone?></td>
						<td><?php echo $supplier->email?></td>
                        <?php 
                             $addresses = $supplierPointer->getSupplierAddress($supplier->sid);
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