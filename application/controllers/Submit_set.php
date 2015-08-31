<?php 


	
	/*
	*
	*This file is responsible for handling the ajax requests for the workout page.
	*
	*/

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Submit_set extends CI_controller {

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

			//workout id
			$workoutID = $_SESSION['workoutID'];
			//send workout log id to the view.
			$workout_log_id = $_SESSION['workout_log_id'];




			/*
			*	Take care of ajax post from javascript
			*/

			echo "Hello";
			//if the submit-set-btn was clicked and the form was submitted
			if( isset( $_POST['submit-set-btn'] ) ) {
				//get all post data
				$weight = $_POST['weight'];
				$reps = $_POST['reps'];
				$rest = $_POST['rest'];
				$exerciseID = $_POST['exerciseID'];
				$workoutID = $_POST['workoutID'];
				$workout_log_id = $_POST['workout-log-id'];

				$this->Database_model->enter_set( $userID, $workoutID, $workout_log_id, $exerciseID, $weight, $reps, $rest, $difficulty );

				//get the sets to return to the javascript file to be posted in the view
				$sets = previous_exercise_sets_h( $userID, $exerciseID );
				$sanitized_html = sanitize_object_h( $sets );
				//send the sanitized data.
				echo json_encode( $sanitized_html );

			}//end if
		
		}//end index()

	}//end Home class

 ?>