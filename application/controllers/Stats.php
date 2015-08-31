<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stats extends CI_controller {

		public function index() {
			
			//loads a unique javascript file in the footer for this particular page
			$data['javascript'] = 'gains.js';
			//this variable is created for the "main" file in view/layouts/main.  Main takes $main_content and uses it to load the view 'products.php'.
			$data['main_content'] = 'Stats';
			//load a view and pass it the data object to use in the view.  For instance, to use $data['name'] = "mike" in the view simply use "$name".
			$this->load->view('layouts/main', $data);
		}//end index()

	}//end Home class

 ?>