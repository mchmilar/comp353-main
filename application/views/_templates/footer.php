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
</body>
</html>
