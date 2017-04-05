/**
 * Created by markc on 4/4/2017.
 */
$(document).ready(function() {
    $('#projects-table').DataTable();


    // Make table rows clickable as links
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

} );