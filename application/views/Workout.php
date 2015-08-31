 	<div id="errors"></div>
	<div class="row">
		<div class="columns  medium-8 medium-offset-2 workout-title">
			<h1 class="centered"><?php echo escape_output( $workoutDetails->name ); ?></h1>
	    	<h5 class="centered white"><span class="title-description">Description:</span> <?php echo escape_output( $workoutDetails->description ); ?></h5>
		</div>
	</div>
    

    <div class="row margin-top">
    	<h3 class="centered white">Set Rest Timer</h3>
    	<div class="centered">
    		<span class="rest-clock"><i id="rest-clock-icon" class="fa fa-clock-o"></i></span>
    	</div>
    	<div id="timer-container" class="columns medium-6 medium-offset-3 timer-container">
    		<h4 class="centered white">Set Timer (seconds)</h4>
			<div class="margin-top">
				<div class="centered">
					<div class="row">
						<div class="columns medium-6 medium-offset-3">
							<input id="timer-setting" type="number" placeholder="Timer" value="90">
						</div>
					</div>
				</div>
			    <div class="centered margin">
			    	<button id="timer-start" class="button tiny success">Start</button>
					<button id="timer-stop" class="button tiny Default">Stop</button>
					<button id="timer-reset" class="button tiny secondary">Reset</button>
			    </div>
			</div>
		</div>
	</div>
	
	<div class="log-workout-exercises columns  medium-8 medium-offset-2">
		<div class="centered margin-top">
			<h3 class="white">Exercises For This Workout</h3>
		</div>

		<!-- <div class="row centered">
			<h3>
				<a title="Add Exercise" href="#" data-reveal-id="add-exercise"> <span class="white"><i class="fa fa-plus-square"></i></span></a>
			</h3>
		</div> -->

		
		<!-- begin workout exercises -->
		<?php foreach( $exercisesForWorkout as $exercise ): ?>
		<div class="row">
	      <div class="columns medium-8 medium-offset-2">
	      	<div class="muscle-group">
	          <h4 class="centered"><?php echo escape_output( $exercise->name ); ?>
	            <!-- <a href="#" data-reveal-id="delete-exercise"><span class="delete-workout" title="Delete Workout"><i class="fa fa-times"></i></span></a> -->
	          </h4>
	        </div>
	        <div class="row log-exercise-container exercises">
	        	<div>
					<div class="row stats-section">
						<div class="columns small-6 stats-log">
							<h5 class="white centered">Previous</h5>
							  <ul>	
							  	<!-- begin previous exercise sets -->
							  	<!-- if there is enough data -->
							  	<?php if( previous_exercise_sets2_h( $userID, $exercise->id, $workout_log_id ) ): ?>
									<?php foreach( previous_exercise_sets2_h( $userID, $exercise->id, $workout_log_id ) as $set ): ?>
					                	<li class="centered <?php exercise_difficulty_h( $set->difficulty ); ?>">
					                		<?php format_weight_reps_rest_h( $set->weight, $set->reps, $set->rest ); ?>
					                	</li>
					            	<?php endforeach; ?>
					            <?php else: ?>
					            	<li class="centered white">Not Enough Data</li>
					            <?php endif; ?>
					            <!-- end previous exercise sets -->
				                <!-- <li class="centered medium">45lbs x 10 - 45secs</li>
				                <li class="centered hard">45lbs x 10 - 45secs</li>
				                <li class="centered very-hard">45lbs x 10 - 45secs</li> -->
				              </ul>
						</div>
						<div class="columns small-6 stats-log">
							<h5 class="white centered">Current</h5>
							<!-- data attribute helps determine if a current workout has been initiated - if it has we need to load any exercises that have been done for today in this workout -->
							<ul class="todays-sets">
								<!-- if sets have already been entered for this workout - load them -->
								<?php if( previous_exercise_sets_h( $userID, $exercise->id, $workout_log_id ) ): ?>
									<?php foreach( previous_exercise_sets_h( $userID, $exercise->id, $workout_log_id ) as $set ): ?>
					                	<li class="centered <?php exercise_difficulty_h( $set->difficulty ); ?>"  data-set-id="<?php echo $set->id; ?>" data-exercise-id="<?php echo $exercise->id; ?>" >
					                		<?php format_weight_reps_rest_h( $set->weight, $set->reps, $set->rest ); ?>
					                		<a class="delete-set-btn" href="#" data-reveal-id="delete-set-modal">
					                			<span class='delete-set'><i class='fa fa-times'></i></span>
					                		</a>
					                		<!-- edit functionality -->
					                		<!-- <a href="#" data-reveal-id="edit-set-modal"><span class='edit-set'><i class='fa fa-pencil-square'></i></span></a> -->
					                	</li>
					            	<?php endforeach; ?>
					            <?php endif; ?>
				            </ul>
						</div>
					</div>
		
	        		
					<!-- begin log exercises -->
			        <div class="log-exercise">
			        	<h5 class="white centered">Enter Sets</h5>
			        	<!-- begin enter set container -->

			        	<div class="enter-set-container">
			        		<form class="submit-set-form" action="#">
					        	<div class="row">
					        		<div class="columns medium-6">
						        		<label for="weight">Weight (lbs)&ast;</label><input class="weight-input" type="number" name="weight">
						        	</div>
						        	<div class="columns medium-6">
						        		<label for="reps">Reps&ast;</label><input class="reps-input" type="number" name="reps"> 
						        	</div>
					        	</div>
					        	<div class="row">
						        	<div class="columns medium-6">
						        		<label for="rest">Rest Time (secs)</label><input class="rest-input" type="number" name="rest"> 
						        	</div>
						        	<div class="columns medium-6">
						        		<label for="difficulty">Difficulty</label>
						        		<select class="difficulty-input" name="difficulty">
						        			<option ></option>
						        			<option value="1">1</option>
						        			<option value="2">2</option>
						        			<option value="3">3</option>
						        			<option value="4">4</option>
						        			<option value="5">5</option>
						        		</select>
						        	</div>
						        	<!-- hidden inputs to send to php -->
						        	<input type="hidden" name="exerciseID" value="<?php echo escape_output ( $exercise->id ); ?>">
						        	<input type="hidden" name="workoutsID" value="<?php echo escape_output ( $workoutID ); ?>">
						        	<input type="hidden" name="workout-log-id" value="<?php echo escape_output ( $workout_log_id ); ?>" >
						        
						        	
						        	<div class="centered">
						        		<input type="submit" class="enter-set-btn button small secondary" value="Enter Item" name="submit-set-btn">
						        	</div>
						        	<!-- success box -->
						        	<!-- <div class="row success-alert-box centered">
						        		<div class="centered alert-box success radius">
										 Set Added!
										</div>
						        	</div> -->
						        	<!-- success box -->
						        </div>
						    </form>
				        </div>
				        <!-- end enter set container -->
			        </div>
			        <!-- end log exercises -->

	        	</div>
	        </div>
	      </div>
	    </div>
		<?php endforeach; ?>
	    <!-- end workout exercises -->
	</div>
	<!-- end log-workout-exercises class -->

    
    <div class="row margin-top">
    <!-- 	<div class="centered">
    		<button class="button round success">Submit Workout</button>
    	</div>
    	<div class="centered">
    		<button class="button round alert">Cancel Workout</button>
    	</div> -->
    </div>


    <div id="timer" class="timer centered"></div>


	<!-- delete exercise modal -->
    <!-- <div id="delete-exercise" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	  <h2 class="centered" id="modalTitle">Delete exercise from this workout?</h2>
	  <div class="centered">
	  	<button class="button success small">Yes</button>
	  </div>
	  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div> -->
	<!-- delete exercise modal -->



	<!-- add workout modal -->
	<!-- <div id="add-exercise" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 class="centered">Add Exercises <br>to Workout</h2>
		<div class="medium-4 medium-offset-4 columns centered">
            <select class="margin-top" name="add_exercise" id="">
				<option value="">Existing Exercises</option>
				<option value="">Preacher Curl</option>
				<option value="">Squats</option>
				<option value="">Arnold Curl</option>
				<option value="">Shoulder Shrugs</option>
				<option value="">Dumbell Press</option>
			</select>
            <div class="centered">
              <button class="button success small">Add Existing Exercise</button>
            </div>
            <h4>OR</h4>
            <h5 class="margin-top">Create and Add New Exercise</h5>
            <input type="text" placeholder="Name">
            <textarea placeholder="description" name="" id="" cols="30" rows="10"></textarea>
            <h5>Is this exercise cardio?</h5>
            <label for="yes-cardio"><input id="yes-cardio" type="radio" name="cardio" value="yes">Yes</label>
            
            <label for="no-cardio">
            	<input id="no-cardio" type="radio" name="cardio" value="no">No
            </label>
			
            <div class="centered">
              <button class="button success small">Add New Exercise</button>
            </div>
          </div>	
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div> -->
	<!-- add workout modal -->




	<!-- begin delete set modal -->
	<div id="delete-set-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	  <h4 class="centered">Delete this set</h4>
	  <div class="centered">
	  	<form action="#" id="delete-modal-form" method="post">
	  		<input type="hidden" id="modal-exercise-id" name="exerciseID">
	  		<input type="hidden" id="modal-set-id" name="setID">
	  		<input class="button alert" type="hidden" value="Delete" name="delete_exercise_submit">
	  		<input id="delete-set-submit" class="button alert" type="submit" value="Delete">
	  	</form>
	  </div>
	  <a id="close-delete-set-modal" class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>
	<!-- end delete set modal -->


	<!-- edit set modal -->
	<div id="edit-set-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	  <h2 id="modalTitle">Awesome. I have it.</h2>
	  <p class="lead">Your couch.  It is mine.</p>
	  <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
	  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>
	<!-- edit set modal -->


	<!-- audio for the alarm -->
	<?php echo base_url(); ?>assets/css/application.css
	<audio id="alarm-sound" src="<?php 	base_url() ?>assets/audio/alarm.mp3">




    <!-- footer block -->
    <div id="footer">
      <div>
        <p class="centered"><span class="ripped">RIPPED</span><br>All Rights Reserved &copy; 2015</p>
      </div>
    </div>
    <!-- footer block -->


    <!-- get the base URL for javascript--> 
  	<input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  
   



  



