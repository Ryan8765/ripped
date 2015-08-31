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
    <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <!-- no errors -->
    <?php if ( empty($errors) ): ?>
        <h2 class="centered white margin-top">Congtratulations, you have confirmed your email for <span class="ripped">Ripped</span>.</h2>
        <h3 class="centered white margin-top"><a href="<?php base_url(); ?>login">Login</a></h3>
    <?php endif; ?>
    <!-- no errors -->

    
    <!-- errors -->
    <?php if ( !empty($errors) ): ?>
        <h2 class="centered white margin-top">Please check the URL and try again.</h2>
    <?php endif; ?>
    <!-- errors -->
	
    



   
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