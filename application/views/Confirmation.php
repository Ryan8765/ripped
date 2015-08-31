<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ripped</title>
    <!-- foundation styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
    <!-- custom styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/application.css" />
    <!-- google font -->
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
  </head>
  <body>


	<h2 class="centered white margin-top">Congtratulations!  You have signed up for <span class="ripped">Ripped</span></h2>

	<h3 class="centered white">Please check your email to confirm the registration process.</h3>



   
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
    <!-- this provides a unique javascript file if one is set in the controller -->
    <?php if( isset( $script ) ): ?>
    	<script src="<?php echo base_url(); ?>assets/js/<?php echo $script; ?>"></script>
    <?php endif; ?>
  </body>
</html>