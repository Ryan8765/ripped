<?php 

	
	/*
	*
	*This file is responsible for handling the ajax requests for the workout page.
	*
	*/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class submit_set extends CI_controller {

		public function index() {
			
			

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

			//get the current workoutlogID
			$global_workout_log_id = $_SESSION['workout_log_id'];




			/*
			*	Handle delete set functionality
			*/
			//if the delete set form has been submitted
			if( isset($_POST['delete_exercise_submit']) ) {
				//get posted variables
				$exerciseID = $_POST['exerciseID'];
				$setID = $_POST['setID'];

				//delete the set from the database.
				$this->Database_model->delete_set( $userID, $setID );


				
				//return the sets to the javascript file
				$sets = previous_exercise_sets_h( $userID, $exerciseID, $global_workout_log_id );
				$sanitized_html = sanitize_object_h( $sets );
				//send the sanitized data.
				echo json_encode( $sanitized_html );

			}//end if
		




			/*
			*	Take care of ajax post from javascript
			*/

			//if the submit-set-btn was clicked and the form was submitted
			if( isset( $_POST['weight'] ) && isset( $_POST['reps'] ) ) {
				
				//get all post data
				$weight = $_POST['weight'];
				$reps = $_POST['reps'];
				$rest = $_POST['rest'];
				$exerciseID = $_POST['exerciseID'];
				$workoutID = $_POST['workoutsID'];
				$difficulty = $_POST['difficulty'];
				$workout_log_id = $_POST['workout-log-id'];

				$this->Database_model->enter_set( $userID, $workoutID, $workout_log_id, $exerciseID, $weight, $reps, $rest, $difficulty );



				//get the sets to return to the javascript file to be posted in the view
				$sets = previous_exercise_sets_h( $userID, $exerciseID, $global_workout_log_id );
				$sanitized_html = sanitize_object_h( $sets );
				//send the sanitized data.
				echo json_encode( $sanitized_html );

			}//end if



			
		



		}//end index()

	}//end Home class

 ?>