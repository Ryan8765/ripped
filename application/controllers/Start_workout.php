<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Start_workout extends CI_controller {

		public function index() {
			$this->load->library('session');
			//custom javascript filename to include
			$data['javascript'] = 'start_workout.js';


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
			*	get all user workouts and pass it to the view
			*/
			$workouts = $this->Database_model->get_all_user_workouts_asc( $userID );
			$data['workouts'] = $workouts;
			

		
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Start_workout';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);
		}//end index()

	}//end Home class

 ?>