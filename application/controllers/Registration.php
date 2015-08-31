<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Registration extends CI_controller {

		public function index() {

			$db = $this->load->database();
			$this->load->library('email');

			// /*
			// *	Function to send an email through codigniter email.  Returns false if email doesn't send. 
			// */
			// function send_email_h( $to, $from, $message, $subject ) {
			// 	$this->load->library('email');

			// 	$this->email->from('rmhaas2211@gmail.com', 'Ripped');
			// 	$this->email->to( $to ); 

			// 	$this->email->subject( $subject );
			// 	$this->email->message( $message );

			// 	//return false if email doesn't send. 
			// 	if ( !$this->email->send()) {
			// 	    return false;
			// 	}	

			// }
			// //end send_email()

			
			
			/*
			*	If the form has been submitted check the user input
			*/
			if( isset($_POST['submit']) ) {
				
				//get registration variables from form
				$fname = $_POST['first_name'];
				$lname = $_POST['last_name'];
				$email = $_POST['email'];
				$weight = $_POST['weight'];
				$password = $_POST['password'];
				$password_confirm = $_POST['password_confirm'];
				$submit = $_POST['submit'];
				

				//variable to log errors to.
				$errors = array();


				//logs which inputs there were problems with in the registration process - this variable is used in the view to show "red" alerts.
				$logInputErrors = array();



			

				/*
				*	Make sure all fields are filled out on a form. Uses a variable (not in the function) called $errors to log errors to as it checks if fields are filled out.  Modify the interior array in this function to change form fields.  The values in the array need to match the $_POST names of the input fields. 
				*/

				
				//make sure required fields have been filled out.
				$required_fields = array(
					'First Name'       => 'first_name',
					'Last Name'        => 'last_name',
					'Email'            => 'email',
					'Your weight'	   => 'weight',	
					'Password'         => 'password',
					'Confirm Password' => 'password_confirm'
				);

				foreach( $required_fields as $key=>$value ) {
					if ( !isset($_POST[$value]) ) {
						$errors[] = $value . "is a required field.";
						$logInputErrors[] = $key;
					}
					//end if
				}
				//end foreach
					
				//check to make sure passwords match - log an error if not. 
				if( !do_passwords_match_h( $password, $password_confirm ) ) {
					$errors[] = "Passwords don't match.";
					$logInputErrors[] = "password";
					$logInputErrors[] = "password_confirm";
				}
				//end if
				
				//first name alphabetic - log an error if not.
				if( !is_alphabetic_h( $_POST['first_name'], "First name", "first_name" ) ) {
					$errors[] = "Use alphabetic characters for your first name only.";
					$logInputErrors[] = "first_name";
				}

				//last name alphabetic - log an error if not.
				if( !is_alphabetic_h( $_POST['last_name'], "First name", "last_name" ) ) {
					$errors[] = "Use alphabetic characters for your last name only.";
					$logInputErrors[] = "last_name";
				}
				//end if
				
				//weight is a number - log an error if not. 
				if( !is_number_h( $_POST['weight'], "Weight", "weight" ) ) {
					$errors[] = "Use numeric characters for your weight.";
					$logInputErrors[] = "weight";
				}
				


				//make sure user doesn't already exist by checking for their email.
				if( $this->Database_model->user_already_exists( $email ) ) {
					$errors[] = "I am sorry, but that email already exists in the database.";
					$logInputErrors[] = "email";
				}
				//end check if user exists

				//make sure password is greater than 5 characters 
				if ( strlen ($password) < 5 ) {
					$errors[] = "Password needs to be greater than 5 characters long.";
					$logInputErrors[] = "password";
					$logInputErrors[] = "password_confirm";
				}

				//if there are no errors logged, then log into database.
				if( empty($errors) ) {
					//key used for sending a confirmation email unique url
					$key = rand_token_h(15);
					//send a confirmation email to the new user
					$to = $email;
					$from = 'rmhaas2211@gmail.com';
					$subject = "Ripped Registration";
					$message = "Thanks for signing up with Ripped.  To complete the registration process please click the following link: \n" . base_url() . "complete_signup?key=" . $key . "&fname=" . $fname;
					
					//send the email - if there is an error log it. 

					$this->email->from('rmhaas2211@gmail.com', 'Ripped');
					$this->email->to( $to ); 

					$this->email->subject( $subject );
					$this->email->message( $message );

					//log an error if email doesn't send. 
					if ( !$this->email->send()) {
					    $errors[] = "There was a problem sending the email, please check your email address and try again".
						$logInputErrors[] = "email";
					}
					//end if	
					
					
					
					

					//send data to database if there are still no errors.
					if ( empty( $errors ) ){
						$this->Database_model->log_new_user_information( $fname, $lname, $password, $email, $weight, $key );

						redirect(base_url() . 'confirmation');
					}
					//end if
				}
				// end if

				

				//if there are errors pass them to the view
				if( !empty($errors) ) {
					$data['errors'] = $errors;
					$data['logInputErrors'] = $logInputErrors;
				}
			}
			//end if isset submit


			

			


	
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Registration';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('Registration', $data);
		}//end index()

	}//end Home class

 ?>