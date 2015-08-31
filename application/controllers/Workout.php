<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Workout extends CI_controller {

		public function index() {
			
			//custom javascript filename to include
			$data['javascript'] = 'workout.js';

			$this->load->library('session');


			/*
			*make sure session is valid and check session user agent to help prevent session hijacking. 
			*/
			$redirect_path = base_url() . "login";
			//check that user is logged in
			if ( !isset($_SESSION['loggedIn']) ) {
				redirect( $redirect_path );
			}

			//get user id from the session
			$userID = $_SESSION['userID'];
			//check session user agent
			$session_name = "userAgent";
			check_session_user_agent_h($redirect_path, $session_name);







			
			/*
			* If a workout has been initiated, else redirect
			*/

			if( isset( $_POST['workoutID'] )  || isset( $_SESSION['workoutID'] ) ) {

				//if a new workout has been initiated - reset the workoutID variable and session variable.  Else set it equal to the session workout variable - this helps if a person accidentilly leaves the workout page....the workout is still accessable.
				if( isset( $_POST['workoutID'] ) ) {
					//brand new workout - get workoutID and set the session workout variable.
					$workoutID = $_POST['workoutID'];
					$_SESSION['workoutID'] = $workoutID;
					$this->Database_model->log_new_workout( $userID, $workoutID );
					//get and set the workout_log id variable - used to access previous exercise sets
					$_SESSION['workout_log_id'] = $this->Database_model->get_latest_workout_log_id( $userID );

				} else { 

					$workoutID = $_SESSION['workoutID'];
				
				}
				//end if

				//send workout log id to the view.
				$data['workout_log_id'] = $_SESSION['workout_log_id'];



				//send the workout ID to the view
				$data['workoutID'] = $workoutID;




				/*
				*  Handle getting all the exercises for a workout
				*/

				$exercisesForWorkout = $this->Database_model->get_all_exercises_for_workout( $userID, $workoutID );
				$data['exercisesForWorkout'] = $exercisesForWorkout;
 				


				//get all workout information and send it to the view
				$workoutDetails = $this->Database_model->get_workout_details( $userID, $workoutID );
				$data['workoutDetails'] = $workoutDetails;

			} else {
				redirect( base_url() . "start_workout" );
			}
			//end if





			$data['userID'] = $userID;
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Workout';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);
		}//end index()

	}//end Home class

 ?>