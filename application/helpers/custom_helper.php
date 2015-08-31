<?php 

	/*
	*	function to create a random token - $length is the length of the random token you want generated.
	*/
	function rand_token_h($length) {
		$token = bin2hex( openssl_random_pseudo_bytes($length / 2) );  
		return $token;
	}
	//end rand_token
	
	/*
	*	Make sure string is alphabetic - if not log errors
	*/
	function is_alphabetic_h( $string, $fieldname, $inputName ) {
		global $errors, $logInputErrors;
		if( ctype_alpha($string) ) {
			return true;
		} else {
			return false;
		}
		//end if
	}
	//end is_alphabetic_h()


	/*
	*	Function to check string for numbers only from an input element.
	*/
	function is_number_h( $string, $fieldname, $inputName ) {
		

		if( ctype_digit($string) ) {
			return true;
		} else {
			return false;
		}
		//end if
	}
	//end is_alphabetic_h()



	/*
	* 	Make sure passwords match
	*/
	function do_passwords_match_h($pass1, $pass2) {
		global $errors, $logInputErrors;

		if ( $pass1 == $pass2 ) {
			return true;
		} else {
			return false;
		}
	}
	//end matching_passwords


	/*
	*	Function for the registration view - checks to see if an input wasn't entered correctly - it it there was an error with it produce the class "input-errors" for the element.  Provide the input name to see if it is in the log of errors produced in the registration controller - the array "loginputerrors" is created in the controller and is a list of all the input names with errors.
	*/

	function input_has_an_error_h( $input_name, $logInputErrors ) {
		if( !empty($logInputErrors) ) {
			if( in_array($input_name, $logInputErrors) ) {
				echo "class='input-errors'";
			}
			//end if
		}
		//end if
		
	}
	//end input_has_an_error



	/*
	*	re-enter input that was already entered on page submission when there are errors. 
	*/ 

	function reenter_input_values_h( $inputName ) {
		if( isset($_POST[$inputName]) ) {
			echo "value='" . $_POST[$inputName] . "'";
		}
		//end if
	}
	//end reenter_input_values_h



	/*
	*	Check if the user agent session variable has been set, if not set it.  Also checks to make sure valid user agent for the current session...if not redirect.  It takes a redirect_path variable to send the user to if the session doesn't match. It also takes a session_name variable which names the user agent session variable. 
	*/
	function check_session_user_agent_h( $redirect_path, $session_name ) {

		//if a sessoin user agent has been set, check to make sure it is the same one.  Otherwise redirect.
	
		if( isset($_SESSION[$session_name]) ) {
			if( $_SERVER['HTTP_USER_AGENT']  != $_SESSION[$session_name] ) {
				header("Location:" . $redirect_path);
			}
			//end if
		} else {
			header("Location:" . $redirect_path);
		}
		//end if
	}
	//end session_user_agent()



	/*
	*	Check that a session has been initiated, if not redirect to login.  Takes a session parameter which checks the current session to make sure its value is set to "true"
	*/
	function check_if_logged_in_h( $session ) {
		if( $_SESSION[$session] != true ) {
			header("Location:".BASE_URL."login");
		}
	}
	//end check_if_logged_in_h


	/*
	*	escape output function
	*/

	function escape_output( $string ) {
		$escape_output = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
		return $escape_output;
	}
	//end escape_output

	/*
	*  Custom date helper function. 
	*/

	function format_date_h($date) {
		$formatted_date = date("M j, Y",strtotime($date));
		return $formatted_date;
	}//end format_date()


	/*
	*	Function to get the latest date you did an exercise.
	*/

		
	function exercise_last_done_date_h( $exerciseID, $userID ) {

		$CI =& get_instance();

		$CI->db->select_max('date');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID);

		$query = $CI->db->get()->row();

		$date = $query->date;

		//if not data
		if( !$date ) {
			echo "Not enough data";
			return false;
		}

		//format the date
		$date = format_date_h($date);


		return $date;

	}
	//end user_already_exists





	/*
	*	
	*/

	function previous_exercise_sets3_h( $userID, $exerciseID ) {
		// $currentDate = getdate();
		$CI =& get_instance();


		//get the latest workout_log_id that was done which that exercise was done in.
		$CI->db->select_max('workout_log_id');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID);
		$workout_log_id_max = $CI->db->get()->row()->workout_log_id;

		

		
		//use the latest workout ID to return the exercise sets that were done in that workout.
		$CI->db->select('*');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID); 
		$CI->db->where('workout_log_id
			', $workout_log_id_max); 
		$sets = $CI->db->get()->result();


		//if no data
		if( empty($sets) ) {
			return false;
		}

		return $sets;
	}//end previous_exercise_sets






	/*
	*	Get all sets of the last workout of an exercise - even if it was today
	*/

	function previous_exercise_sets_h( $userID, $exerciseID, $currentWorkoutLogID ) {
		// $currentDate = getdate();
		$CI =& get_instance();


		//get the latest workout_log_id that was done which that exercise was done in.
		// $CI->db->select_max('workout_log_id');
		// $CI->db->from('sets');
		// $CI->db->where('exercises_id
		// 	', $exerciseID);
		// $CI->db->where('users_id
		// 	', $userID);
		// $workout_log_id_max = $CI->db->get()->row()->workout_log_id;

		

		
		//use the latest workout ID to return the exercise sets that were done in that workout.
		$CI->db->select('*');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID); 
		$CI->db->where('workout_log_id
			', $currentWorkoutLogID); 
		$sets = $CI->db->get()->result();


		//if no data
		if( empty($sets) ) {
			return false;
		}

		return $sets;
	}//end previous_exercise_sets


	/*
	*	Get all sets of the last workout of an exercise - gets all exercises for previous workout that isn't the current workout.  $workout_log_id is the id of the workout currently being done.
	*/
	function previous_exercise_sets2_h( $userID, $exerciseID, $workout_log_id ) {
		$CI =& get_instance();
		
		//get the last workout_log_id that was done.
		$CI->db->select_max('workout_log_id');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID);
		$CI->db->where('workout_log_id <>
			', $workout_log_id);
		$CI->db->order_by("date", "asc"); 
		$workout_log_id_previous = $CI->db->get()->row()->workout_log_id;
		
		


		//get the workout before that
		$CI->db->select('*');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID);
		$CI->db->where('workout_log_id
			', $workout_log_id_previous);
		$CI->db->order_by("date", "asc"); 
		$sets = $CI->db->get()->result();

		//if no data
		if( empty($sets) ) {
			return false;
		}

		return $sets;
	}//end previous_exercise_sets


	/*
	*	How hard an exercise was - produce the class for the current set of an exercise - very-easy, easy, medium, hard, very-hard.  $difficulty is a parameter that accepts numbers 1-5.  1 corresponding to very easy and 5 corresponding to very hard. 
	*/

	function exercise_difficulty_h( $difficulty ) {
		//make sure it is an acceptable number.
		if( $difficulty < 1 || $difficulty > 5 ) {
			return false;
		}//end if

		//ge the integer value in case of string
		$difficulty = intval( $difficulty ) - 1;

		



		$difficultyLevels = array(
			"very-easy",
			"easy",
			"medium",
			"hard",
			"very-hard" 
		);

		$html = $difficultyLevels[$difficulty];

		echo $html;
	}
	//end exercise_difficulty

	/*
	*	Create a function to format the reps and sets and rest for output
	*/

	function format_weight_reps_rest_h( $weight, $reps, $rest = 0 ) {
		//if no data provided.
		if( !$weight ) {
			echo "Not enough data.";
			return false;
		}
		//end if
		if ( $rest > 0 ) {
			$formatted = $weight . "lbs x " . $reps . " - " . $rest . "s";
		} else {
			$formatted = $weight . "lbs x " . $reps;
		}

		echo $formatted;
		
	}//end format_reps_sets





	/*
	*	Get the maximum weight for an exercise. 
	*/

	function max_weight_for_exercise_h( $userID, $exerciseID ) {
		
		$CI =& get_instance();

		//get the last date done
		$CI->db->select('*');
		$CI->db->select_max('weight');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('users_id
			', $userID);
		//don't want the date to be the current one
		// $CI->db->where('date <', 'NOW()'); 

		$set = $CI->db->get()->row();
		
		$weight = $set->weight;
		$reps = $set->reps;
		$rest = $set->rest;

		//if there isn't a value 
		if( !$weight ) {
			echo "Not enough data";
			return;
		}
		//end if

		format_weight_reps_rest_h( $weight, $reps, $rest );
	}//end previous_exercise_sets


	/*
	*	Last weight increase and how much it was. 
	*/

	function last_weight_increase_h( $userID, $exerciseID ) {

		$CI =& get_instance();

		//get the last weight increase
		$CI->db->select('*');
		$CI->db->select_max('weight');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('new_maximum
			', 1);
		$CI->db->where('users_id
			', $userID);
		//don't want the date to be the current one
		// $CI->db->where('date <', 'NOW()'); 

		$set1 = $CI->db->get()->row();
		$weight1 = $set1->weight;
		//if no weight 1 return false
		if( !$weight1 ) {
			echo "Not enough data.";
			return false;
		}


		//get the last increase before the current one. 
		$CI->db->select('*');
		$CI->db->select_max('weight');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('new_maximum
			', 1);
		$CI->db->where('users_id
			', $userID);
		$CI->db->where('weight <
			', $weight1);


		$set2 = $CI->db->get()->row();
		$weight2 = $set2->weight;

		//if no  weight 2 return false.
		if( !$weight2 ) {
			echo "Not enough data.";
			return false;
		}

		//get the difference in weight
		$weightDifference = $weight1 - $weight2;
		$date = $set1->date;
		$date = format_date_h( $date );


		echo $weightDifference . "lbs - " . $date; 		

	}
	//end last_weight_increase_h()



	/*
	*	Average weight increase helper - get the average of all weight increases for this exercise 
	*/

	function average_weight_increase_h ( $userID, $exerciseID ) {
		$CI =& get_instance();
		//an array of all the weight increases
		$allWeights = array();
		//an array with all of the increases in weight
		$weightDifferences = array();

		//get the last weight increase
		$CI->db->select('*');
		$CI->db->from('sets');
		$CI->db->where('exercises_id
			', $exerciseID);
		$CI->db->where('new_maximum
			', 1);
		$CI->db->where('users_id
			', $userID);
		$CI->db->order_by("date", "asc");
 

		$rows = $CI->db->get()->result();

		//if there isn't enough data don't do that calculation.
		if( count($rows) < 2 ) {
			echo "Not enough data";
			return;
		}
		
		//add all the weights to the allweights variable.
		foreach( $rows as $row ) {
			$allWeights[] = $row->weight;
		}
		//endforeach

		//add the weight differences to the weightdifferences array.
		for ( $i = 0; $i < count($allWeights) - 1; $i++ ) {
			//add the weight differences to the array.
			$weightDifferences[] = $allWeights[$i + 1] - $allWeights[$i];
		}
		//end for


		//find the average
		$average = array_sum($weightDifferences) / count($weightDifferences);
		$average = $average;

		//return the average
		echo $average . " lbs";


	}//end average weight increase ()



	/*
	*	Function to sanitize rows of data from an array that contains objects - works for rows returned by database fetchAll function. 
	*/

	function sanitize_object_h( $array ) {
		$array_modified = $array;
		if ( $array_modified ) {
			foreach( $array_modified as $object ) {
				foreach( $object as &$item ) {
					$item = htmlentities( $item, ENT_QUOTES );
				}
				//end foreach
			}
			//end foreach
			return $array_modified;
		} else {
			return false;
		} //end if
		
		
	}
	//end sanitize_object_h
	
	
 ?>