<?php 

	/*
	*	This model takes care of any of the user table data.
	*/

	class Database_model extends CI_Model {

		/*
		*	Determines if the user already exists
		*/
		public function user_already_exists( $email ) {
			// $this->load->database();

			$query = $this->db->get_where( 'users', array('email' => $email) );
			$row = $query->row();

			// $query = "SELECT * FROM users 
			// 		  WHERE email = :email";
			// $statement = $this->$db->prepare($query);
			// $statement->bindValue(':email' , $email);
			// $statement->execute();
			// //fetch the row as an object
			// $row = $statement->fetch(PDO::FETCH_OBJ);

			return $row;

		}
		//end user_already_exists


		/*
		*	Enter new user information into database.
		*/
		public function log_new_user_information( $fname, $lname, $password, $email, $weight, $key ) {

			
			//options for encrypting
			$options = [
				//cost is basically a way to slow down brute force attacks.  It takes more resources to do a brute force attack.  10 is the recommended value
			    'cost' => 11,
			    //used to salt the password.
			    'salt' => rand_token_h( 22 )
			];
			


			//deal with encrypting the password.  password_hash is a php function.
			$password = password_hash($password, PASSWORD_BCRYPT, $options);

			//create a key to add to database so that you can send custom link to verify email address.

			$data = array(
			   'fname' => $fname ,
			   'lname' => $lname ,
			   'pass' => $password,
			   'email' => $email ,
			   'weight' => $weight,
			   'salt' => $options['salt'],
			   'key' => $key
			);

			$this->db->insert('users', $data); 
		} 
		//end log_user_information


		/*
		*	Finishes the registration process - checks email and key in the database and if it exists it changes the active status to "1".
		*/
		public function confirm_registration_process( $key, $fname ) {

			$query = $this->db->get_where( 'users', array('fname' => $fname, 'key' => $key) );
			$row = $query->row();
			//if that key and email is in the database - change that members active status to 1, else send false.
			if( !empty($row) ) {
				$data = array(
				               'active' => 1,
				            );

				$this->db->where('fname', $fname);
				$this->db->where('key', $key);
				$this->db->update('users', $data);
				return true; 
			} else {
				return false;
			}
			//end 
		}
		//end confirm_registration_process()




		/*
		*	Function to check login.  Returns false if not a valid user, true if a valid user and active, and a 1 if a valid user but not active.
		*/

		public function is_valid_user( $email, $password ) {
			//get the user based off of the email
			$query = $this->db->get_where( 'users', array('email' => $email) );
			$user = $query->row();
			//if that is not an email address in the database return false.
			if( empty($user) ) { 
				return false;
			}

			//if that user isn't active return 1
			if( $user->active === 0 ) {
				return 1;
			}
			//

			$user_password_database = $user->pass;

			$user_salt_database = $user->salt;
			
			//options for encrypting
			$options = [
				//cost is basically a way to slow down brute force attacks.  It takes more resources to do a brute force attack.  10 is the recommended value
			    'cost' => 11,
			    //used to salt the password.
			    'salt' => $user_salt_database
			];

			$user_password = password_hash( $password, PASSWORD_BCRYPT, $options );

		


			//if incorrect password return false else return true
			if ( $user_password_database != $user_password ) {
				return false;
			} else {
				return true;
			}

		}
		//end is valid user()



		/*
		*	Function to get userId of a user given their email
		*/

		public function get_user_id( $email ) {
			//get the user based off of the email
			$query = $this->db->get_where( 'users', array('email' => $email) );
			$user = $query->row();

			return $user->id;
		}
		//end get_user_id


		/*
		*	Get workouts for a particular user
		*/

		public function get_all_user_workouts( $userID ) {
			//get the user based off of the email
			$query = $this->db->get_where( 'workouts', array('users_id' => $userID) );
			$workouts = $query->result();

			return $workouts;
		}
		//end get_all_user_workouts

		/*
		*	Get all exercises for a particular user - where the user hasn't deleted the exercise.
		*/

		public function get_all_user_exercises( $userID ) {
			$this->db->select('*');
			$this->db->from('exercises');
			$this->db->where('users_id', $userID);
			$this->db->where('deleted', null);
			$this->db->order_by("name", "asc");
			$exercises = $this->db->get()->result();
			
			return $exercises;
		}
		//end get_all_user_exercises

		/*
		*	Add a new exercise
		*/

		public function add_exercise( $userID, $name, $description, $is_cardio ) {
			$data = array(
			   'users_id' => $userID ,
			   'name' => $name ,
			   'description' => $description,
			   'type' => $is_cardio
			);

			$this->db->insert('exercises', $data); 
		}
		//end add exercise


		/*
		*	Add workout
		*/

		public function add_workout( $userID, $name, $description ) {

			$data = array(
			   'users_id' => $userID ,
			   'name' => $name ,
			   'description' => $description
			);

			$this->db->insert('workouts', $data); 
		} //end add_workout()


		/*
		*	Get all workouts in ascending order for a particular user.
		*/

		public function get_all_user_workouts_asc( $userID ) {
			$this->db->select('*');
			$this->db->from('workouts');
			$this->db->where('users_id', $userID);
			$this->db->where('deleted', 0);
			$this->db->order_by("name", "asc");
			$workouts = $this->db->get()->result();
			
			return $workouts;
		}
		//end get_all_user_exercises

		/*
		*	Get all exercises for a particular workout and join that with the workouts table. 
		*/

		public function get_all_exercises_for_workout( $userID, $workoutID ) {

			$this->db->select('*', FALSE);
			$this->db->select('workout_exercises.id AS workout_exercisesID', FALSE);
			$this->db->from('workout_exercises');
			$this->db->where('workout_exercises.users_id', $userID);
			$this->db->where('workouts_id', $workoutID);
			$this->db->join('exercises', 'workout_exercises.exercises_id = exercises.id');
			// $this->db->order_by("exercises.name", "asc");
			$workoutExercises = $this->db->get()->result();
			
			return $workoutExercises;

		}  //end get_all_exercises_for_workout()


		/*
		*	Function to get the latest date you did an exercise.
		*/
			
		function exercise_last_done_date_h( $exerciseID, $userID ) {
			$this->db->select_max('date');
			$this->db->from('sets');
			$this->db->where('userID
				', $userID);			

			return $date;

		}//end user_already_exists




		/*
		*	Delete workout functionality - this doesn't delete the workout in the database - it changes its "deleted" column to 1 - need to keep in the database for historical 
		*/

		public function delete_workout( $userID, $workoutID ) {


			$data = array(
               'deleted' => 1
            );

			$this->db->where('users_id', $userID);
			$this->db->where('id', $workoutID);
			$this->db->update('workouts', $data); 

		}//end delete_workout




		/*
		*	Add an exercise to a workout functionality - 
		*/

		public function add_exercise_to_workout( $userID, $exerciseID, $workoutID ) {

			$data = array(
			   'users_id' => $userID ,
			   'exercises_id' => $exerciseID ,
			   'workouts_id' => $workoutID
			);

			$this->db->insert('workout_exercises', $data);
		}//end if


		/*
		*	Delete exercise - this doesn't delete the exercise in the database - it changes its "deleted" column to 1 - need to keep in the database for historical purposes
		*/
		public function delete_exercise( $userID, $exerciseID ) {


			$data = array(
               'deleted' => 1
            );

			$this->db->where('users_id', $userID);
			$this->db->where('id', $exerciseID);
			$this->db->update('exercises', $data); 

		}//end delete_workout


		/*	
		* Function to get the latest exercise ID added
		*/

		public function get_latest_exercise_id( $userID ) {		
			$this->db->select_max('id');
			$this->db->from('exercises');
			$this->db->where('users_id', $userID);
			$query = $this->db->get()->row();

			return $query->id;
		
		}
		//end get_latest_exercise_id


		public function delete_exercise_from_workout( $userID, $workoutExerciseID ) {

			$this->db->where('users_id', $userID);
			$this->db->where('id', $workoutExerciseID);


			$this->db->delete('workout_exercises'); 


		}//end delete_exercise_from_workout()



		/*
		*	Get workout details
		*/

		public function get_workout_details( $userID, $workoutID ) {
			//get the user based off of the email

			$this->db->select('*');
			$this->db->from('workouts');
			$this->db->where('users_id', $userID);
			$this->db->where('id', $workoutID);
			$workout = $this->db->get()->row();

			if( !empty($workout) ) {
				return $workout;
			} else {
				return false;
			}
			//end if
			
		}
		//end get_workout_details()


		/*
		*	Logs a new workout into the log_workout table.  This is basically just used for grabbing previous workout sets. 
		*/

		public function log_new_workout( $userID, $workoutID ) {
			//get the user based off of the email
			
			$data = array(
			   'users_id' => $userID ,
			   'workouts_id' => $workoutID
			);

			$this->db->insert('workout_log', $data);
			
		}
		//end get_workout_details()


		/*
		*	Function to get the latest workout_log id
		*/

		public function get_latest_workout_log_id( $userID ) {
			$this->db->select_max('id');
			$this->db->from('workout_log');
			$this->db->where('users_id', $userID);
			$id = $this->db->get()->row()->id;

			return $id;
			// Produces: SELECT MAX(age) as age FROM members
		}
		//end get_current_workout_log_id




		/*
		*	Get all current sets for the current workout
		*/

		public function get_all_current_sets( $userID, $workout_log_id,  $exerciseID ) {

		}
		//end get_all_current_sets


		/*
		*	Enter a set into sets table
		*/

		public function enter_set( $userID, $workoutID, $workout_log_id, $exerciseID, $weight, $reps, $rest, $difficulty ) {
			//is this a new maximum lift
			$newMaxLift = false;

			//first need to get the current maximum weight for this exercise so we can log a new max lift if this is one.
			$this->db->select_max('weight');
			$this->db->from('sets');
			$this->db->where('users_id', $userID);
			$this->db->where('exercises_id', $exerciseID);
			$maxWeight = $this->db->get()->row()->weight;

			//if this is a new maximum lift set newMaxLIft to true.
			if ( $maxWeight < $weight ) {
				$newMaxLift = true;
			}//end if



			if ( $newMaxLift ) {

				$data = array(
				   'users_id' => $userID ,
				   'workouts_id' => $workoutID ,
				   'workout_log_id' => $workout_log_id ,
				   'exercises_id' => $exerciseID ,
				   'weight' => $weight ,
				   'reps' => $reps ,
				   'rest' => $rest ,
				   'difficulty' => $difficulty,
				   'new_maximum' => 1
				);

				$this->db->insert('sets', $data); 

			} else {

				$data = array(
				   'users_id' => $userID ,
				   'workouts_id' => $workoutID ,
				   'workout_log_id' => $workout_log_id ,
				   'exercises_id' => $exerciseID ,
				   'weight' => $weight ,
				   'reps' => $reps ,
				   'difficulty' => $difficulty,
				   'rest' => $rest
				);

				$this->db->insert('sets', $data); 

			}//end if
			


		}
		//end enter_set


		/*
		*	function to delete a set
		*/

		public function delete_set( $userID, $setID ) {
			
			$this->db->where('users_id', $userID);
			$this->db->where('id', $setID);
			$this->db->delete('sets');

		}//end delete_set()




		



	}//end Image_model class

 ?>