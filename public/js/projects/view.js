/**
 * Created by markc on 4/4/2017.
 */
$(document).ready(function() {
    //$('#tasks-table').DataTable();

    displayPoForm("#po-type-select");
    taskRowClick("#tasks-table > tbody > tr:nth-child(1)");
    $( "#est-delivery" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
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
    $("#tasks-table > tbody > tr").each(function() {
        $(this).removeClass("selected-task");
    });
    $( selected ).addClass("selected-task");
    $(".po-content").fadeOut({
        duration: 200,
        done: function() {
            // Get PO's for selected task
            $.get(url +"pos/ajaxPOsTaskProj/" + pid + "/" + tid,
                function(returnedData){
                    $("#quote-list-table-body").html(returnedData);
                });

            // Display proper PO panel for selected task
            $(".po-task-type-textbox").val(task_name);
            $(".task-name").html(task_name);
            $("#hidden-task-id").val(tid);
            $(".po-content").fadeIn(200);
        }
    });


}

function displayPoForm(selected) {
    var poType = $( selected ).find(":selected").text();
    if (poType.toLowerCase() === 'supply') {
        // display supply po form
        $("#project-task-labour-po").addClass("invisible-panel");
        $("#project-task-supply-po").removeClass("invisible-panel");

        // Disable labour inputs
        var inputs = $("#project-task-labour-po :input");
        $.each(inputs, function(index, value) {
            $(value).prop('disabled', true);
        });

        // Enable supply inputs
        var inputs = $("#project-task-supply-po :input");
        $.each(inputs, function(index, value) {
            $(value).prop('disabled', false);
        });

    } else {
        // display labour po form
        $("#project-task-labour-po").removeClass("invisible-panel");
        $("#project-task-supply-po").addClass("invisible-panel");

        // Disable supply inputs
        var inputs = $("#project-task-supply-po :input");
        $.each(inputs, function(index, value) {
            $(value).prop('disabled', true);
        });

        // Enable labour inputs
        var inputs = $("#project-task-labour-po :input");
        $.each(inputs, function(index, value) {
            $(value).prop('disabled', false);
        });
    }
}