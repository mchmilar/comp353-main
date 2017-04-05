/**
 * Created by markc on 4/4/2017.
 */
$(document).ready(function() {
    $('#tasks-table').DataTable();

    displayPoForm("#po-type-select");
    taskRowClick("#tasks-table > tbody > tr:nth-child(1)");
} );

// Display correct PO form in project view
$("#po-type-select").change(function() {
    displayPoForm(this);
});


// AJAX Call for PO list
$('.task-row').on('click', function(){
    taskRowClick(this);
});

function taskRowClick(selected) {
    var tid = $( selected ).find('.tid-col').text();
    var task_name = $( selected ).find('.task-name-col').text();
    // Get PO's for selected task
    $.get(url +"pos/ajaxPOsTaskProj/" + pid + "/" + tid,
        function(returnedData){
            $("#quote-list-table-body").html(returnedData);
        });

    // Display proper PO panel for selected task
    $(".po-task-type-textbox").val(task_name);
    $("#hidden-task-id").val(tid);
}

function displayPoForm(selected) {
    var poType = $( selected ).find(":selected").text();
    if (poType.toLowerCase() === 'material') {
        // display material po form
        $("#project-task-contractor-po").addClass("invisible-panel");
        $("#project-task-material-po").removeClass("invisible-panel");
    } else {
        // display contractor po form
        $("#project-task-contractor-po").removeClass("invisible-panel");
        $("#project-task-material-po").addClass("invisible-panel");
    }
}