/**
 * Created by mark on 4/8/17.
 */
$(document).ready(function() {
    $("#new-button").click(function() {
        if ( $("#new-po").is(":hidden") ) {
            $("#new-po").slideDown("slow");
        }
    });

    $("#pos-table > tbody > tr").click(function(){
        $("#pos-table > tbody > tr").each(function() {
            $(this).removeClass("selected-task");
        });
        $(this).toggleClass("selected-task");
        var id = $(this).find("td:eq(0)").html();
        $("#selected-task").val(id);
    });

    $("#add-po-button").click(function() {
        var id = $("#phase-id").val();
        window.location.replace(url_with_index_file + "projects/view/" + id);

    });

    $("#edit-po-button").click(function() {
        var id = $("#selected-po").val();
        window.location.replace(url_with_index_file + "pos/edit/" + id);

    });
} );