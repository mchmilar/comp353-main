/**
 * Created by Mark Chmilar on 4/7/2017.
 * Edited by Tarik Abou-Saddik on 4/8/2017.
 */

$(document).ready(function() {

    $("#new-button").click(function() {
        if ( $("#new-supplier").is(":hidden") ) {
            $("#new-supplier").slideDown("slow");
        }
        else
            $("#new-supplier").slideUp("slow");
    });

    var edit_checked = false;

    $("#suppliers-table > tbody > tr").click(function(){
    	
        $("#suppliers-table > tbody > tr").each(function(){
    		$(this).removeClass("selected-supplier");
    	})
    	$(this).toggleClass("selected-supplier");
        var sid = $(this).find("td:eq(0)").html();
        $("#selected-supplier").val(sid);
        edit_checked = true;
    })

    $("#edit-task").click(function() {
        if(edit_checked)
        {
            // Return the value of supplier id set for #selected-supplier. 
            var sid = $("#selected-supplier").val();
            window.location.replace(url_with_index_file + "suppliers/edit/" + sid);
            edit_checked = false;
        }
        else
            alert("Please select a Supplier to edit.");
    });

});

