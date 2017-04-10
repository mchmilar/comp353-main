/**
* @file 
* @author Tarik Abou-Saddik
* @author Mark Chmilar
*
* Handles user triggered events in views/contractors/index.php
*/


$(document).ready(function()
{
	$('#new-button').click(function()
	{
		if($('#new-contractor').is(':hidden'))
			$('#new-contractor').slideDown('slow');
		else
			$('#new-contractor').slideUp('slow');
	});

	var edit_checked = false;

	$('#contractors-table > tbody > tr').click(function()
	{	
		// Remove class from previously selected contractor row
		$('#contractors-table > tbody > tr').each(function(){
			$(this).removeClass("selected-contractor");
		})

		// Add class to selected contractor row (i.e this). 
		$(this).toggleClass("selected-contractor");

		// Find first cell (i.e. contractor id) and return value.
		var cid = $(this).find("td:eq(0)").html();

		// Assign input with #selected-contractor cid value.
		$('#selected-contractor').val(cid);
		edit_checked = true;

	});

	$('#edit-contractor').click(function(){	
		if(edit_checked)
		{	
			// Return id of contractor.
			var cid = $('#selected-contractor').val();

			// Replace current page with the edit.php page.
			// Note: this calls edit() inside controllers/contractors.php
			window.location.replace(url_with_index_file + "contractors/edit/" + cid);
			edit_checked = false;
		}
		else
			alert("Please select a Contractor to edit");
	});

});