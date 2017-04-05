/**
 * Created by markc on 4/4/2017.
 */
$(document).ready(function() {
    $('#tasks-table').DataTable();

    // Display correct PO form in project view
    $("#po-type-select").change(function() {
        var poType = $( this ).find(":selected").text();
        if (poType.toLowerCase() === 'material') {
            // display material po form
            $("#project-task-contractor-po").addClass("invisible-panel");
            $("#project-task-material-po").removeClass("invisible-panel");
        } else {
            // display contractor po form
            $("#project-task-contractor-po").removeClass("invisible-panel");
            $("#project-task-material-po").addClass("invisible-panel");
        }
    });


    // AJAX Call for PO list
    $('.task-row').on('click', function(){
        var tid = $( this ).find('.tid-col').text();
        console.log(url +"pos/ajaxPOsTaskProj");
        $.get(url +"pos/ajaxPOsTaskProj/" + pid + "/" + tid,//, { tid: tid, pid : pid},
            function(returnedData){
            console.log(returnedData);
            $("#quote-list-table-body").html(returnedData);
            });

        // send an ajax-request to this URL: current-server.com/songs/ajaxGetStats
        // "url" is defined in views/_templates/footer.php
     /*   $.ajax(url + "po/ajaxPOsTaskProj")
            .done(function(result) {
                // this will be executed if the ajax-call was successful
                // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                $('#javascript-ajax-result-box').html(result);
            })
            .fail(function() {
                // this will be executed if the ajax-call had failed
            })
            .always(function() {
                // this will ALWAYS be executed, regardless if the ajax-call was success or not
            }); */
    });

} );