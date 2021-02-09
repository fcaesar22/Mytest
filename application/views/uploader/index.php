<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Uploader</title>

    <!-- jquery ui -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css">
    <!-- plupload jquery ui -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css'); ?>">
</head>
<body>

    <form id="form" action="<?php echo base_url() . 'uploader/upload'; ?>" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
        <div id="uploader">
            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
            <input type="submit" value="Submit">
        </div>
        <br>
    </form>

	<!-- preloader -->
	<?php include 'preloader.php'; ?>

    <!-- jquery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <!-- jquery ui -->
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <!-- plupload -->
    <script src="<?php echo base_url('assets/plupload/plupload.full.min.js'); ?>"></script>
    <!-- plupload jquery ui -->
	<script src="<?php echo base_url('assets/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js'); ?>"></script>

    <script>
        BASE_URL  = '<?php echo base_url(); ?>';
        csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        OBJ_CSRF  = {};
        OBJ_CSRF[csrf_name] = csrf_hash;
    </script>

    <!-- plupload init -->
    <?php include 'script.php'; ?>

</body>
</html>
