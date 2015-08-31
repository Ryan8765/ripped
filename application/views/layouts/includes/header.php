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
    
    <!-- begin nav block -->
    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a class="ripped" href="#">Ripped</a></h1>
        </li>
         <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
      </ul>

      <section class="top-bar-section">

        <!-- Left Nav Section -->
        <ul class="right">
          <?php if( isset($_SESSION['workout_log_id']) ): ?>
            <li><a href="<?php echo base_url(); ?>workout">Current Workout</a></li>
          <?php endif; ?>
          <li><a href="<?php echo base_url(); ?>start_workout">Start Workout</a></li>
          <li><a href="<?php echo base_url(); ?>workouts">Workouts</a></li>
          <li><a href="<?php echo base_url(); ?>exercises">Exercises</a></li>
          <li>
          <li><a href="<?php echo base_url(); ?>stats">Stats</a></li>
          <li>
            <a href="<?php echo base_url(); ?>logout">Logout</a>
          </li>
        </ul>
      </section>
    </nav>
    <!-- end nav block -->