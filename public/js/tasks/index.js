/**
 * @file
 * @author Mark Chmilar
 * 
 * Handles user triggered events in views/tasks/index.php
 */
$(document).ready(function() {
    $("#new-button").click(function() {
        if ( $("#new-task").is(":hidden") ) {
            $("#new-task").slideDown("slow");
        }
         else
            $("#new-task").slideUp("slow");
    });

    $("#tasks-table > tbody > tr").click(function(){
        $("#tasks-table > tbody > tr").each(function() {
            $(this).removeClass("selected-task");
        });
        $(this).toggleClass("selected-task");
        var id = $(this).find("td:eq(0)").html();
        $("#selected-task").val(id);
    });

    $("#edit-task").click(function() {
        var id = $("#selected-task").val();
        window.location.replace(url_with_index_file + "tasks/edit/" + id);

    });
} );