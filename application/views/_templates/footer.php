<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
    <script>
        var url = "<?php echo URL_WITH_INDEX_FILE; ?>";
    </script>

    <!-- parsley -->
    <script src="/public/js/parsley.min.js"></script>

    <!-- custom form validators -->
    <script src="/public/js/validators.js"></script>
	
	<!-- bootstrap -->
	<script src="/public/js/bootstrap.min.js"></script>

    <!-- datatables -->
    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

    <!-- our JavaScript -->
    <script src="/public/js/application.js"></script>



<?php

// TODO the "" is weird
// get URL ($_SERVER['REQUEST_URI'] gets everything after domain and domain ending), something like
// array(6) { [0]=> string(0) "" [1]=> string(9) "index.php" [2]=> string(10) "controller" [3]=> string(6) "action" [4]=> string(6) "param1" [5]=> string(6) "param2" }
// split on "/"
$url = explode('/', $_SERVER['REQUEST_URI']);
// also remove everything that's empty or "index.php", so the result is a cleaned array of URL parts, like
// array(4) { [2]=> string(10) "controller" [3]=> string(6) "action" [4]=> string(6) "param1" [5]=> string(6) "param2" }
$url = array_diff($url, array('', 'index.php'));
// to keep things clean we reset the array keys, so we get something like
// array(4) { [0]=> string(10) "controller" [1]=> string(6) "action" [2]=> string(6) "param1" [3]=> string(6) "param2" }
$url = array_values($url);


// Put URL parts into according properties
$url_controller = isset($url[0]) ? $url[0] : null;
$url_action = isset($url[1]) ? $url[1] : null;

// Remove controller and action from the split URL
unset($url[0], $url[1]);

echo '<script src="/public/js/' . $url_controller . '/' . (($url_action) ? $url_action : "index") . '.js"></script>';

// for debugging. uncomment this if you have problems with the URL
//echo 'Controller: ' . $url_controller . '<br>';
//echo 'Action: ' . $url_action . '<br>';

?>
</body>
</html>
