<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Workouts extends CI_controller {

		public function index() {

			//errors array
			$errors = array();

			$this->load->library('session');

			/*
			*make sure session is valid and check session user agent to help prevent session hijacking. 
			*/
			$redirect_path = base_url() . "login";
			//check that user is logged in
			if ( !isset($_SESSION['loggedIn'])) {
				redirect( $redirect_path );
			}

			//get user id from the session
			$userID = $_SESSION['userID'];
			//check session user agent
			$session_name = "userAgent";
			check_session_user_agent_h($redirect_path, $session_name);
			//loads a unique javascript file in the footer for this particular page
			$data['javascript'] = 'workouts.js';


			/*
			*	Add workout 
			*/

			//if user submitted to add a workout
			if ( isset($_POST['add_workout_submit']) ) {
				if( !empty($_POST['add_workout_name']) ) {
					//get the post data
					$name = $_POST['add_workout_name'];
					$description = $_POST['add_workout_description'];

					//add the exercise to the database
					$this->Database_model->add_workout( $userID, $name, $description );

				} else {
					$errors[] = "The name of your workout is a required field.  Please try again.";
				}//end if
			} //end if







			/*
			*	Handle delete workout functionality
			*/

			//if the delete workout form has been submitted
			if( isset($_POST['delete-workout-submit']) ) {


				//get the variables from the post
				$workout_id = $_POST['workout_id'];

				//set the deleted column of the workout to "1" - doesn't delete from database for historical data purposes
				$this->Database_model->delete_workout( $userID, $workout_id );


			} //end if post


			



			/*
			*	Add existing exercise to workout functionality - modal popup
			*/

			//if the user has submitted the form for existing exercise
			if( isset($_POST['add-existing-exercise']) ) {
				//get the post variables
				$existingExerciseID = $_POST['add_existing_exercise_selection'];
				$existingExerciseWorkoutID = $_POST['existing-exercise-workoutID'];

				//update the database
				$this->Database_model->add_exercise_to_workout( $userID, $existingExerciseID, $existingExerciseWorkoutID );
			}//end if

			//if the user has submitted the form for the new exercise portion
			if( isset($_POST['add_new_exercise_workout']) ) {
				//get post variables
				$name = $_POST['name'];
				$description = $_POST['description'];
				$is_cardio = $_POST['is_cardio'];
				$workoutID = $_POST['workoutID'];

				//add the new exercise to the database
				$this->Database_model->add_exercise( $userID, $name, $description, $is_cardio );
				//get the exericse id of that exercise
				$latestExerciseID = $this->Database_model->get_latest_exercise_id( $userID );

				//add the new exercise to the workout
				$this->Database_model->add_exercise_to_workout( $userID, $latestExerciseID, $workoutID );
			}//end if


			/*
			*	Delete exercise from a workout
			*/

			if ( isset($_POST['delete-exercise-from-workout']) ) {


				//set the post variables
				$workout_exercisesID = $_POST['workout_exerciseID'];

				//delete the workout from the database
				$this->Database_model->delete_exercise_from_workout( $userID, $workout_exercisesID );

			}//end if









			/*
			*	Get all workouts and send to the view
			*/

			//get all the workouts from the model.
			$allWorkouts = $this->Database_model->get_all_user_workouts_asc( $userID );

			//send them to the view.
			$data['allWorkouts'] = $allWorkouts;



			



			/*
			*	Load all exercises - the view passes a variable to the controller for the foreach loop of the exercises to obtain the current workout_id from the foreach loop.
			*/

			//variable to store all the workout id's displayed in the view.
			$workoutIDs = array(); 

			//get the workouts for each 
			$workoutExercises = array();
			$workoutExercisestest = array();

			//get all the workout id's for the different workouts to use in the view and add them to above array. Also get all of the exercises for each workout and put them into the workoutExercises array to use in the view.
			foreach ( $allWorkouts as $workout ) {
				$workoutIDs[] = $workout->id;
				$workoutExercises[] = $this->Database_model->get_all_exercises_for_workout( $userID, $workout->id );
			}  //end foreach


			/*
			* Get all user exercises for the add exercise to workout modal popup selection 
			*/

			$allExercises = $this->Database_model->get_all_user_exercises( $userID );


			//pass variables to the view. 
			$data['workoutIDs'] = $workoutIDs;
			$data['workoutExercises'] = $workoutExercises;
			$data['userID'] = $userID;
			$data['allExercises'] = $allExercises;
			//an iterator for the accordian functionality
			$data['iterator'] = 1;


			//pass the errors to the view
			$data['errors'] = $errors;
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Workouts';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);


		}//end index()

	}//end Home class

 ?>