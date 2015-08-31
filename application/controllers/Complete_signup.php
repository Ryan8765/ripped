<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Complete_signup extends CI_controller {

		public function index() {
			

			if ( isset($_GET['key']) ) {
				$key   = $_GET['key'];
			}

			if ( isset($_GET['fname']) ) {
				$fname   = $_GET['fname'];
			}
			
			//errors array 
			$errors = array();

			/*
			* confirm the email registration process - if it isn't confirmed log an error.
			*/

			if ( !$this->Database_model->confirm_registration_process( $key, $fname ) ) {
				$errors[] = "There was an error.  Please check the URL and try again.";
			}

			//pass errors to the view if there are any
			if( !empty($errors) ) {
					$data['errors'] = $errors;
			}

			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Complete_signup';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('Complete_signup', $data);
		}//end index()

	}//end Home class

 ?>