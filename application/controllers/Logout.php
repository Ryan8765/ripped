<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Logout extends CI_controller {

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



			/*
			*	Destroy the session
			*/

			$this->session->sess_destroy();



			/*
			*	Redirect the user to the login page
			*/

			redirect( base_url() . "login" );
			
			
		}//end index()

	}//end Home class

 ?>