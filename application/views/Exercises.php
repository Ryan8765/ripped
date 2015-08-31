  
    <h1 class="centered">Exercises</h1>

    
    <div class="row centered">
        <h3>
          <a title="Add Exercise" href="#" data-reveal-id="add-exercise"> <span class="white"><i class="fa fa-plus-square"></i></span></a>
        </h3>
    </div>
    
    


    <div class="row">
      <div class="medium-10 medium-offset-1 columns">
        <div class="medium-8 medium-offset-2 muscle-exercises">

          <!-- begin errors -->
          <?php if( !empty($errors) ): ?>
            <div class="alert-box alert">
              <?php foreach( $errors as $error ): ?>
                <p class="centered"><?php echo $error; ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <!-- begin errors -->

          


          <!-- begin exercises accordian -->
          <ul class="accordion" data-accordion>
            <!-- begin output all exercises -->
            <?php foreach( $exercises as $exercise ): ?>

              <!-- iterator used for the accordian ID's-->
              <?php $iterator++; ?>

              <li class="accordion-navigation">
                <a href="#panel<?php echo $iterator; ?>"><?php echo escape_output($exercise->name); ?></a>
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
                    <button  data-exercise-id="<?php echo escape_output($exercise->id); ?>" data-exercise-name="<?php echo escape_output($exercise->name); ?>" data-reveal-id="delete-exercise" class="button alert small round delete-exercise-btn">Delete</button>
                   <!--  <button data-reveal-id="edit-exercise" class="button warning small round edit-exercise-btn">Edit</button> -->
                  </div>
                </div>
              </li>
             <?php endforeach; ?>
             <!-- end output all exercises -->
          </ul>
          <!-- end exercises accordian -->
        </div>
        <!-- end muscle exercises -->
      </div>
    </div>
    <!-- end row -->

    
    


    <!-- footer block -->
    <div id="footer">
      <div>
        <p class="centered"><span class="ripped">RIPPED</span><br>All Rights Reserved &copy; 2015</p>
      </div>
    </div>
    <!-- footer block -->



    <!-- begin popup for add muscle group -->
    <div id="add-muscle-group" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
      <h2 class="centered" id="modalTitle">Enter Muscle Group</h2>
      <div class="row">
        <form>
          <div class="medium-4 medium-offset-4 columns centered">
            <input type="text" placeholder="Enter Muscle Group">
            <button class="button success">Submit</button>
          </div>
        </form>
      </div>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
    <!-- end popup for add muscle group -->


   


    <!-- add exercise modal -->
  <div id="add-exercise" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 class="centered">Add Exercise</h2>
    <div class="medium-4 medium-offset-4 columns centered">
      <form method="post" action="<?php echo base_url(); ?>exercises">
        <input type="text" placeholder="Name" name="name" required>
        <textarea placeholder="description" name="description" cols="30" rows="10"></textarea>
        <h5>Is this exercise cardio?</h5>
        <select name="is_cardio" id="" required>
          <option value="1">No</option>
          <option value="0">Yes</option>
        </select>

        <div class="centered">
          <input type="submit" id="add-exercise-submit" class="button success small" name="add-exercise-submit" value="Add New Exercise">
        </div>
      </form>
    </div>  
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>
  <!-- add exercise modal -->

  <!-- delete exercise modal -->
  <div id="delete-exercise" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <div class="centered">  
        <h3 id="delete-exercise-modal-title" class="centered">Delete This Exercise?</h3>
        <form action="<?php base_url(); ?>exercises" method="post">
          <input id="delete-exercise-id" type="hidden" name="exercise_id">
          <input class="button small round alert" type="submit" value="delete" name="delete_exercise_submit">
        </form>
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>
  <!-- delete exercise modal -->


  <!-- Edit exercise modal -->
  <!-- <div id="edit-exercise" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <div class="centered">  
        <h2>Edit Exercise</h2>
    </div>

    <div> 
        <form action="">
          <label>Name</label>
          <input type="text">

          <label>Description</label>
          <textarea cols="30" rows="10"></textarea>
        </form>

    </div>
    
    <div class="centered">  
        <button class="button small round success">Update</button>
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div> -->
  <!-- Edit exercise modal -->


  <!-- get the base URL for javascript--> 
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />



