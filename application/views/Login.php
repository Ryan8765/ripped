<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ripped</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/application.css" />
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
  </head>
  <body>


    
    <!-- login form -->
    <div class="large-3 large-centered columns">
      <div class="login-box">
        <div class="row">
          <div class="large-12 columns">

            <!-- log errors -->
            <?php if( isset($errors) ): ?>
              <div data-alert class="alert-box alert">
                <?php foreach( $errors as $error ): ?>
                  <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <!-- log errors -->
            
            <form action="<?php base_url(); ?>login" method="post">
               <h4 class="ripped centered">Ripped Login</h4>
               <div class="row">
                 <div class="large-12 columns">
                     <input type="email" name="email" placeholder="Username" required />
                 </div>
               </div>
              <div class="row">
                 <div class="large-12 columns">
                     <input type="password" name="password" placeholder="Password" required />
                 </div>
              </div>
              <div class="row">
                <a href="#">Sign Up</a>
              </div>
              <div class="row">
                <a href="#">Forgot Password</a>
              </div>
              <div class="row">
                <div class="large-12 large-centered columns">
                  <input type="submit" class="button success expand" value="Log In" name="submit"/>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
    </div>
    <!-- login form -->

    



    
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
