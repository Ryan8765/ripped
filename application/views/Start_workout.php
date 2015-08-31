


    <h1 class="centered">Start Your Workout</h1>

  
    <div class="row margin-large">
      <div class="columns medium-6 medium-offset-3">
        <h3 class="centered white">Select Workout</h3>
        <div class="centered">
          <form id="submit-workout" action="<?php base_url(); ?>workout" method="post">
            <select id="selected-workout" name="workoutID">
              <option value="">Select Workout</option>

              <!-- post all workouts from database -->
              <!-- value is the workout-id from database -->
              <?php foreach( $workouts as $workout ): ?>
                <option value="<?php echo escape_output( $workout->id ); ?>"><?php echo escape_output( $workout->name ); ?></option>
              <?php endforeach; ?>
              <!-- end post all workouts from database -->
            </select>
          </form>
        </div>
        <?php if( isset($_SESSION['workout_log_id']) ): ?>
          <h4 class="centered ripped">You currently have a workout in progress!! <br>  If you select another one - the current workout will end.</h4>    
        <?php endif; ?>
      </div>
    </div>

  




    

