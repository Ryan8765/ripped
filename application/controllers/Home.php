<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_controller {

		public function index() {
			/*
			*make sure session is valid and check session user agent to help prevent session hijacking. 
			*/
			$redirect_path = base_url() . "login";
			//check that user is logged in
			if ( isset($_SESSION['loggedIn']) ) {
				redirect( $redirect_path );
			}
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Home';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);
		}//end index()

	}//end Home class


 ?>