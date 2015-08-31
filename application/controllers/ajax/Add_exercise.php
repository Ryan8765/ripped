<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Add_exercise extends CI_controller {

		public function index() {

			$this->load->library('session');


			/*
			*make sure session is valid and check session user agent to help prevent session hijacking. 
			*/
			$redirect_path = base_url() . "login";
			//check that user is logged in
			if ( $_SESSION['loggedIn'] != true ) {
				redirect( $redirect_path );
			}

			//get user id from the session
			$userID = $_SESSION['userID'];
			//check session user agent
			$session_name = "userAgent";
			check_session_user_agent_h($redirect_path, $session_name);

			//if add an exercise has been submitted 
			if ( isset($_POST['add-exercise-submit']) ) {
				if( !empty($_POST['name']) ) {
					//get the post data from ajax request.
					$name = $_POST['name'];
					$description = $_POST['description'];
					$is_cardio = $_POST['is_cardio'];

					//add the exercise to the database
					$this->Database_model->add_exercise( $userID, $name, $description, $is_cardio );
					echo "true";
				} else {
					echo "Fill out name";
				}
				//end if
				
			} else {
				echo "false";
			}
			//end if


		}//end index()

	}//end Home class

 ?>