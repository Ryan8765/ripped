<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login extends CI_controller {

		public function index() {
			$db = $this->load->database();
			//errors array
			$errors = array();

			//if form has been submitted.
			if ( isset($_POST['submit']) ) {

				$email = $_POST['email'];
				$password = $_POST['password'];
				$is_valid_user = $this->Database_model->is_valid_user( $email, $password );
				//if not a valid user log an error.
				if ( !$is_valid_user ) {
					$errors[] = "Not a valid email or password, please try again.";
				}


				//if user hasn't activated their account
				if ( $is_valid_user === 1 ) {
					echo "<h1> 2 </h1>";
					$errors[] = "You have not yet activated your account.  Please check your email and visit the provided link to activate it, or enter your email address to get another email.";
				}

				//pass errors to the view.
				$data['errors'] = $errors;

				//if it is a valid user set the session variable.
				if ( $is_valid_user ) {
					//get the user id
					$userID = $this->Database_model->get_user_id( $email );
					//load session
					$this->load->library('session');
					//set session variable user email
					$this->session->set_userdata('userID', $userID);
					//set loggin in status to true
					$this->session->set_userdata('loggedIn', true);

					//log the user user-agent to check later - stop session hijacking
					$this->session->set_userdata('userAgent', $_SERVER['HTTP_USER_AGENT']);
	

					redirect( base_url() . "start_workout" );
				}
				//end if valid user



				
			}
			//end if submit
			
	
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Login';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('Login', $data);
		}//end index()

	}//end Home class

 ?>