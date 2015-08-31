<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ripped</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/foundation.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/application.css" />
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>/assets/js/vendor/modernizr.js"></script>
  </head>
  <body>

    <h3 class="ripped margin-top centered">Ripped Registration</h3>
      
    <!-- registration from -->
    <div class="registration-form margin-top">

      <!-- registration errors -->
      <?php if( !empty($errors) ): ?>
        <div data-alert class="alert-box alert">
          <h5 class="centered white">Registration Errors</h5>
          <?php foreach( $errors as $error ): ?>
            <p><?php echo $error; ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <!-- end registration errors -->

      <form action="<?php base_url(); ?>registration" method="post">
        <div class="row">
              <label class="white">First Name</label>
              <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'first_name', $logInputErrors );} ?> required type="text" placeholder="First Name" name="first_name" <?php if( isset($_POST['first_name']) ) { reenter_input_values_h( 'first_name' );} ?>>
            
        </div>
        <div class="row">
              <label class="white">Last Name</label>
                <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'last_name', $logInputErrors );} ?>  required type="text" placeholder="Last Name" name="last_name" <?php if( isset($_POST['last_name']) ) { reenter_input_values_h( 'last_name' );} ?>>
           
        </div>
        <div class="row">
              <label class="white">Email</label>
              <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'email', $logInputErrors );} ?> required type="email" placeholder="Email" name="email" <?php if( isset($_POST['email']) ) { reenter_input_values_h( 'email' );} ?>>
        </div>
        <div class="row">
              <label class="white">Current Weight</label>
              <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'weight', $logInputErrors );} ?> required type="text" placeholder="Current Weight" name="weight" <?php if( isset($_POST['weight']) ) { reenter_input_values_h( 'weight' );} ?>>
        </div>
        <div class="row">
              <label class="white">Password</label>
              <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'password', $logInputErrors );} ?> required type="Password" placeholder="Password" name="password">
        </div>
        <div class="row">
              <label  class="white">Confirm Password</label>
              <input <?php if( !empty($logInputErrors) ) {input_has_an_error_h( 'password_confirm', $logInputErrors );} ?> required type="Password" placeholder="Confirm Password" name="password_confirm">
        </div>
        <input name="submit" type="submit" class="button success" value="submit">
      </form>
    </div>
    <!-- registration from -->


    <!-- footer block -->
    <div id="footer">
      <div>
        <p class="centered"><span class="ripped">RIPPED</span><br>All Rights Reserved &copy; 2015</p>
      </div>
    </div>
    <!-- footer block -->


    



    
    <script src="<?php echo base_url(); ?>/assets/js/vendor/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
