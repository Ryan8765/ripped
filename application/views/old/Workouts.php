
    <h1 class="centered">Workouts</h1>



    <p class="centered margin-top"><a href="#" class="button success round" data-reveal-id="add-workout">Add New Workout</a></p>

    <!-- errors -->
    <div class="row">
      <div class="medium-10 medium-offset-1 columns">
        <!-- begin errors -->
          <?php if( !empty($errors) ): ?>
            <div class="alert-box alert">
              <?php foreach( $errors as $error ): ?>
                <p class="centered"><?php echo $error; ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <!-- begin errors -->
      </div>
    </div>
    <!-- errors -->
    
    
    
    

    <?php foreach( $allWorkouts as $key => $value ): ?>
      <div class="row">
        <div class="medium-10 medium-offset-1 columns">
          <!-- begin workouts -->
            <div class="muscle-group">
              <h4 class="centered">
                <div class="workout-name"><?php echo escape_output( $value->name ); ?></div>   
                <a href="#" data-reveal-id="add-exercise-group"><span data-workout-id="<?php echo $value->id; ?>" class="add-exercise" title="Add exercise to this workout"><i class="fa fa-plus"></i></span></a>

                <a href="#" data-reveal-id="delete-workout"><span data-workout-id="<?php echo $value->id; ?>" class="delete-workout" title="Delete Workout"><i class="fa fa-times"></i></span></a>
              </h4>
            </div>

            
            <!-- begin muscle exercises -->
            <div class="medium-8 medium-offset-2 muscle-exercises workout-exercises">
              <!-- begin exercises accordian -->
              <ul class="accordion" data-accordion>

                <!-- if there are exercises post them -->
                <?php if( !empty( $workoutExercises ) ): ?>
                  <!-- begin posting each exercise for this workout -->
                  <?php foreach( $workoutExercises[$key] as $exercise ): ?>
                     
                    <!-- iterator used for the accordian ID's-->
                    <?php $iterator++; ?>


                    <li class="accordion-navigation">
                      <a class="exercise-name" href="#panel<?php echo $iterator; ?>"><?php echo escape_output( $exercise->name ); ?></a>
                      <div id="panel<?php echo $iterator; ?>" class="content">
                        <h4 class="centered">Stats<br><span class="stats-help" title="Help"><i class="fa fa-question-circle"></i></span></h4>
                        <table>
                          <tr>
                            <th>Last Done</th>
                            <td><?php echo escape_output( exercise_last_done_date_h( $exercise->id, $userID ) );?></td>
                          </tr>
                          <tr>
                            <th>Last Sets/Reps</th>
                            <td>
                              <ul>
                                <!-- begin exercise sets -->
                                <?php if( previous_exercise_sets3_h( $userID, $exercise->id ) ): ?>
                                  <?php foreach( previous_exercise_sets3_h( $userID, $exercise->id ) as $set ): ?>
                                    <li class="centered <?php exercise_difficulty_h( $set->difficulty ); ?>">
                                      <?php format_weight_reps_rest_h( $set->weight, $set->reps, $set->rest ); ?>
                                    </li>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <li class="centered">
                                    <?php echo "Not enough data"; ?>
                                  </li>
                                <?php endif; ?>
                                <!-- end exercise sets -->
                              </ul>
                            </td>
                          </tr>
                          <tr>
                            <th>Avg Weight Increase</th>
                            <td><?php average_weight_increase_h ( $userID, $exercise->id ); ?></td>
                          </tr>
                          <tr>
                            <th>Last Weight Increase</th>
                            <td><?php last_weight_increase_h( $userID, $exercise->id ); ?></td>
                          </tr>
                          <tr>
                            <th>Max Weight</th>
                            <td><?php max_weight_for_exercise_h( $userID, $exercise->id ); ?></td>
                          </tr>
                          <tr>
                            <th>Description</th>
                            <td><?php echo $exercise->description; ?></td>
                          </tr>
                        </table>
                        <div class="centered">   
                            <a href="#" data-reveal-id="myModal">
                              <button class="button alert small round delete-exercise-from-workout" data-workout-id = "<?php echo escape_output( $value->id ); ?>" data-workout-exercise-id="<?php echo escape_output($exercise->workout_exercisesID); ?>"  data-exercise-name="<?php echo escape_output( $exercise->name ); ?>"  data-workout-name="<?php echo escape_output( $value->name ); ?>">Delete Exercise from Workout</button>
                            </a>         
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                  <!-- end posting each exercise for this workout -->
                <?php endif; ?>
              </ul>
              <!-- end exercises accordian -->
            </div>
            <!-- end muscle exercises -->
          </div>
      </div>
      <!-- end row -->
    <?php endforeach; ?>
    <!-- end workouts -->
    
    


    <!-- footer block -->
    <div id="footer">
      <div>
        <p class="centered"><span class="ripped">RIPPED</span><br>All Rights Reserved &copy; 2015</p>
      </div>
    </div>
    <!-- footer block -->





    
    <!-- delete workout popup -->
    <div id="delete-workout" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
      <h3 class="centered delete-workout-modal-text" id="modalTitle">Delete workout?</h3>
      <div class="row centered">
        <form action="<?php base_url(); ?>workouts" method="post">
          <input id="workout-id-form-input" type="hidden" name="workout_id">
          <input class="button success" value="Yes" type="submit" name="delete-workout-submit">
        </form>
      </div>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- end delete workout popup -->


    <!-- add workout popup -->
    <div id="add-workout" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
      <h2 class="centered" id="modalTitle">Add New Workout</h2>
      <div class="row centered">
        <form action="<?php base_url(); ?>workouts" method="post">
          <input type="text" placeholder="Workout Name" name="add_workout_name" required>
          <textarea name="add_workout_description" cols="30" rows="10" placeholder="Workout Description"></textarea>
          <input type="submit" class="button success" value="Submit" name="add_workout_submit">
        </form>
      </div>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- end add workout popup -->



    


    <!-- begin popup for add exercise -->
    <div id="add-exercise-group" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
      <h2 class="centered" id="add-exercise-modal-popup-text">Add Exercises <br>to Workout</h2>
      <div class="medium-4 medium-offset-4 columns centered">
          <form action="<?php base_url(); ?>workouts" method="post">  
            <h5 class="margin-top">Select Existing Exercise</h5>
            <select name="add_existing_exercise_selection">
              <!-- begin all exercises selection - value is the exercise id number-->
              <?php foreach( $allExercises as $exercise ): ?>
                <option value="<?php echo escape_output($exercise->id); ?>"><?php echo escape_output($exercise->name); ?></option>
              <?php endforeach; ?>
              <!-- begin all exercises selection -->
            </select>
            <div class="centered">
              <!-- takes workout id and sends to the server -->
              <input id="existing-exercise-workoutID" type="hidden" name="existing-exercise-workoutID">
              <input type="submit" class="button success small" value="Submit" name="add-existing-exercise">
            </div>
          </form>
          <h4>OR</h4>
          <h5 class="margin-top">Create and Add New Exercise</h5>
          <form action="<?php base_url() ?>workouts" method="post">
            <input type="text" placeholder="Name" name="name">
            <textarea placeholder="description" name="description" cols="30" rows="10"></textarea>
            <h5>Is this exercise cardio?</h5>
            <label for="yes-cardio"><input id="yes-cardio" type="radio" name="is_cardio" value="1" >Yes</label>
            
            <label for="no-cardio">
              <input id="no-cardio" type="radio" name="is_cardio" value="0" checked="checked">No
            </label>
            <input id="existing-exercise-workoutID-2" type="hidden" name="workoutID">
            <div class="centered">
              <input name="add_new_exercise_workout" type="submit" class="button success small" value="Add New Exercise">
            </div>
          </form>
      </div>  
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- end popup for add exercise -->


    
    <!-- delete exercise from workout modal popup -->
    <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
      
      <h3 id="delete-exercise-modal-title" class="centered">Are you sure you want to delete this exercise?</h3>
      <div class="row centered">
        <form action="<?php base_url(); ?>workouts" method="post">
          <input id="delete-exercise-exerciseID" type="hidden" name="workout_exerciseID">
          <input type="submit" class="button alert" value="Delete" name="delete-exercise-from-workout">
        </form>
      </div>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- delete exercise from workout modal popup -->




    
 
