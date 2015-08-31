<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Exercises extends CI_controller {

		public function index() {
			//errors array
			$errors = array();

			$this->load->library('session');
			//custom javascript filename to include
			$data['javascript'] = 'exercises.js';


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
			*	Add exercise functionality
			*/

			//if user submitted to add an exerise
			if ( isset($_POST['add-exercise-submit']) ) {
				if( !empty($_POST['name']) ) {
					//get the post data from ajax request.
					$name = $_POST['name'];
					$description = $_POST['description'];
					$is_cardio = $_POST['is_cardio'];

					//add the exercise to the database
					$this->Database_model->add_exercise( $userID, $name, $description, $is_cardio );

				} else {
					$errors[] = "The name of your exercise is a required field.";
				}
				//end if
				
			}







			/*
			*	If user deletes an exercise in the modal popup
			*/

			if( isset($_POST['delete_exercise_submit']) ) {
				//get the id of the exercise to be deleted
				$exerciseToDeleteID = $_POST['exercise_id'];

				//delete the exercise in the database - changes it's deleted column to 1 and leaves the exercise for historical purposes.
				$this->Database_model->delete_exercise( $userID, $exerciseToDeleteID );
			}//end if isset



			/*
			*	Get all user exercises and pass it to the view
			*/

			$exercises = $this->Database_model->get_all_user_exercises( $userID );
			$data['exercises'] = $exercises;
			$data['errors'] = $errors;


			//iterator - used for accordian in the view
			$data['iterator'] = 0;
			$data['userID'] = $userID;


			




			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Exercises';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);
		}//end index()

	}//end Home class

 ?>