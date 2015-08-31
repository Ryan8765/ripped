$(document).ready(function() {

	//gets the php base URL of the current page
	var BASE_URL = $('#base_url').val();


	function set_input_rest_time() {
		var timerSetting = $('#timer-setting').val();
		$('.rest-input').val( timerSetting );
	}

	//function to set default rest time


	//function to make sure only digits
	function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}

	/*
	*	Enter a set ajax call and functionality object
	*/

	var postSetLogic = {

		weightInput: null,
		repsInput: null,
		restInput: null,
		difficultyInput: null,
		weightInputElement: null,
		repsInputElement: null,
		difficultyInputElement: null,
		restInputElement: null,
		//stores the elements that have errors in the input field.
		errorElements: [],

		//gets and stores the inputs the user has entered - takes the "enter" button element that was clicked as a parameter
		getInputs:  function( clickedButton ) {
			//get the values
			this.weightInput = clickedButton.closest('.log-exercise-container').find('.weight-input').val();
			this.repsInput = clickedButton.closest('.log-exercise-container').find('.reps-input').val();
			this.restInput = clickedButton.closest('.log-exercise-container').find('.rest-input').val();
			
			this.difficultyInput = clickedButton.closest('.log-exercise-container').find('.difficulty-input').val();
			

			//get the elements
			this.weightInputElement = clickedButton.closest('.log-exercise-container').find('.weight-input');
			this.repsInputElement = clickedButton.closest('.log-exercise-container').find('.reps-input');
			this.difficultyInputElement = clickedButton.closest('.log-exercise-container').find('.difficulty-input');
			this.restInputElement = clickedButton.closest('.log-exercise-container').find('.rest-input');
		},
		//validate inputs checks each input for required values - if it finds an error it logs the element in the errorElements array which is then highlighted red with a border in the view.
		validateInput: function() {
			this.errorElements = [];

			
			//if no value for weight input, log an error.
			if( this.weightInput === null ) {
				this.errorElements.push( 'weight-input' );
			}//end if

			//if weight input isn't a number
			if( !isNumber(this.weightInput) ) {
				this.errorElements.push( 'weight-input' );
			}//end if


			//if no value for reps input, log an error.
			if( this.repsInput === null ) {
				this.errorElements.push( 'reps-input' );
			}//end if

			//if reps input isn't a number
			if( !isNumber(this.repsInput) ) {
				this.errorElements.push( 'reps-input' );
			}//end if

			//if rest input has a value and isn't a number log an error.
			if( this.restInput ) {
				if( !isNumber(this.restInput) ) {
					this.errorElements.push( 'rest-input' );
				}//end if
			}//end if

		}, //end validate function




		//takes an array of error elements to highlight in the view.
		showErrors: function(clickedButton, array) {
			var arrayLength = array.length;
			var container = clickedButton.closest('.log-exercise');
			var currentElement;


			//all of the input elements that could get an error.
			var inputElements = [
				$('.rest-input'),
				$('.weight-input'),
				$('.reps-input'),
				$('.difficulty-input')
			];

			var inputLength = inputElements.length;

			
			// reset all errors in case this is the second submission

			for( var i = 0; i < inputLength; i++ ) {
				if( inputElements[i].hasClass('input-errors') ) {
					inputElements[i].removeClass('input-errors');
				}
			}//end for




			//if there are errors - highlight the errors in the view.
			if( arrayLength > 0 ) {
				for ( var i = 0;  i < arrayLength; i++ ) {
					currentElement = container.find('.' + array[i] );
					currentElement.addClass('input-errors');
				}//end for
				return true;
			}//end if
		}, //end show errors

		//builds the html from the data returned by the ajax call.
		buildListItems: function( data ) {
			if( !data ) {
				return "<li> Not Enough Data </li>";
			}
			//function that outputs the difficulty class
			function difficultyClass( difficulty ) {

				if( difficulty < 1 || difficulty > 5 ) {
					return;
				}

				var difficultLevels = [
					'very-easy',
					'easy',
					'medium',
					'hard',
					'very-hard'
				];
				return difficultLevels[difficulty - 1];

			}//end difficultyClass()

			
			//variable used to build the html with
			var html = "";

			console.log( data );
			//parse the JSON from the php
			var data = $.parseJSON( data );



	

			//data is an array of objects passed back from php
			var dataLength = data.length;


			for ( var i = 0; i < dataLength; i++ ) {

				// data-set-id="<?php echo $set->id; ?>" data-exercise-id="<?php echo $exercise->id; ?>"



				html += "<li data-set-id='";
				html += data[i]['id'] + "' data-exercise-id='";
				html += data[i]['exercises_id'] + "' ";
				html += "class='centered ";
				html += difficultyClass( data[i]['difficulty'] ) + "'>";
				html += data[i]['weight'];
				html += "lbs x ";
				html += data[i]['reps'];
				html += " - ";
				if ( data[i]['rest'] > 0 ) {
					html += data[i]['rest'];
					html += " secs";
				}
				html += "<a class='delete-set-btn' href='#' data-reveal-id='delete-set-modal'><span class='delete-set'><i class='fa fa-times'></i></span></a>";	



			}//end for
			return html;
		},

		//takes the errors array from above
		postData: function( clickedButton, array ) {
			
			//used to access buildlist items from within another function - "this" doesn't work nested inside two functions.
			var buildListItems = this.buildListItems;
			var weightInput = this.weightInputElement;
			var difficultyInput = this.difficultyInputElement;
			var repsInput = this.repsInputElement;
			var restInput = this.restInputElement;
	
			//list item container
			var listItemContainer = clickedButton.closest('.log-exercise-container').find('.todays-sets');
	
			//return the color of the input boxes to white if there were errors
			var arrayLength = array.length;


			//if there are errors - highlight the errors in the view.
			if( arrayLength > 0 ) {
				for ( var i = 0;  i < arrayLength; i++ ) {
					array[i].css('background-color', 'white');
				}//end for
			}//end if

			//get inputs from the view
			this.getInputs( clickedButton );
			//run the error function to log any errors and highlight the boxes if there are in the view.
			this.showErrors( clickedButton, this.errorElements );

			//get the form to submit
			var form = clickedButton.closest('.submit-set-form');
			//if there are no errors send post data.
			if( this.errorElements.length === 0 ) {
				$.post(BASE_URL + "ajax/submit_set", form.serialize() )
				.done(function(data){
					
					// $('.success-alert-box').fadeIn(800);
					// setTimeout(function(){ 
					// 	 $('.success-alert-box').fadeOut(800);
					// }, 1000);

					//update the list items with the new data.
					listItemContainer.html( buildListItems( data ) );
					//send the input elements back to nothing
					
					weightInput.val("");
					difficultyInput.val("");
					repsInput.val("");
					restInput.val("");

				}).
				fail(function(data){
					var stuff = JSON.stringify(data);
					$('#errors').html(stuff);
				});
				//end post
			}//end if

		} //end postData


	}; //end postsetlogic object


	//when a user submits a set 
	$(document).on('click', '.enter-set-btn', function(event) {
		//stop the normal form submission.
		event.preventDefault();
		// set_input_rest_time();

		
		
		
		//button that was clicked on the page - helps to track down the right form data to submit.
		var clickedButton = $(this);

		//load the inputs
		postSetLogic.getInputs( clickedButton );
		//validate the inputs
		postSetLogic.validateInput();

		//show the errors in the view and
		//if there are no errors then go ahead with the post
		if ( !postSetLogic.showErrors( clickedButton, postSetLogic.errorElements ) ) {
			postSetLogic.postData( clickedButton, postSetLogic.errorElements );
		}//end if

		//restart the timer
		reset_time();
	});//end on click




	//if a workout has been initiated already - we need to populate the current workout sets into the view of the current workout.

	// function load_current_workout_sets ()  {
	// 	//if a workout has been initiated - load the workout sets into the view
	// 	//this gets a data attribute set in the view - 1 means a workout is currently under way - 0 means it's not.
	// 	var workoutStarted = $('.todays-sets').attr('data-workout-started');
	// 	var currentElement;
	// 	if( workoutStarted ) {
	// 		//for each exercise - enter the post data.
	// 		$('.enter-set-btn').each( function( index ) {
	// 			currentElement = $(this);
	// 			//load the inputs
	// 			postSetLogic.getInputs( currentElement );
	// 			//get the post data
	// 			postSetLogic.postData( currentElement, postSetLogic.errorElements );
	// 		});
	// 	}//end if
	// }//end load_current_workout_sets



	

	








	/*
	*	Create when you click on the timer icon, it should show the timer container.
	*/
	$('#rest-clock-icon').on('click', function() {
		$('#timer-container').slideToggle();
	});






	/*
	*	Clock functionality
	*/

	//function that plays the alarm sound.
	function play_alarm () {
	  $('#alarm-sound')[0].volume = 1;
	  $('#alarm-sound')[0].load();
	  $('#alarm-sound')[0].play();
	  clearInterval(timer.countdown);
	}

	function pause_alarm () {
		
	  	$('#alarm-sound')[0].pause(); 
	
	}

	//create a timer object - this works by replacing text in an "element" with a counter variable number.  All inputs are in seconds.
	var timer = {
		countdown: null,
		start_timer: function ( time, element ) {
			//so we can access the variable later on in another nested function.
			var countdown = this.countdown;
			pause_alarm();
			// set_input_rest_time();
			//check to make sure timer isn't already going.  If it is clear the interval so it doesn't create two timers going.
			if ( this.countdown != null ) {
				clearInterval(this.countdown);
			}
			//counter to keep track of the current second.
			var counter = time;

			//start the timer functionailty at time 0 so there is no delay when the user clicks "start"
			if ( counter > 0 ) {
				counter = counter - 1;
				element.text(counter);
			}


			//start countdown - if counter is variable is not greater than 0 continue countdown, else end countdown.
			this.countdown = setInterval(function(){
				if ( counter > 0 ) {
					counter = counter - 1;
					element.text(counter);

				} else {
					 /***** note the clear interval comes from the timer function play_alarm() outside of the timer object *********/

					 //vibrate the device if the counter goes to 0.
					 play_alarm();
					 setTimeout(function(){ pause_alarm(); }, 5000);


					 //make the navigator vibrate if possible
					 var vibrateEnabled = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
					//if vibrate is enabled - vibrate the device
					if ( vibrateEnabled ) {
						// vibration API supported
						avigator.vibrate([100,30,100,30,100]);
					} //end if
					 
					 
				}
				//end if
				
			}, 1000);
		},

		//end my_timer
		timer_reset: function( time ) {
			clearInterval(this.countdown);

			this.start_timer( time, $('#timer') );
		},

		timer_stop: function() {
			clearInterval(this.countdown);
		}

	};
	//end timer object


	//function to start the timer.
	function start_timer() {
		if ( $('#timer').text() > 0 ) {
			timer.start_timer( $('#timer').text(), $('#timer') );
		} else {
			timer.start_timer( $('#timer-setting').val(), $('#timer') );
		}
	}//end start timer

	//function to reset the timer
	function reset_time() {
		timer.timer_reset( $('#timer-setting').val() );
	}//end reset_time
	

	

	//funcationality for resetting the timer. 
	$(document).on('click', '#timer-reset', function() {
		timer.timer_reset( $('#timer-setting').val() );			
	});

	//funcationality for stopping the timer. 
	$(document).on('click', '#timer-stop', function() {
		timer.timer_stop();
	});

	//funcationality for starting the timer. 
	$(document).on('click', '#timer-start', function() {
		//if there is still time left on the timer clock - continue going down from there - if not, get the input start value for the time. 
		if ( $('#timer').text() > 0 ) {
			timer.start_timer( $('#timer').text(), $('#timer') );
		} else {
			timer.start_timer( $('#timer-setting').val(), $('#timer') );
		}
		//end if
		
	});




	/*
	*	Hide and show exercise details when user clicks an exercise.
	*/

	$('.muscle-group').on('click', function() {
		var clickedElement = $(this);
		var exerciseContainers = $('.exercises');
		//clicked elements display - allow it to close if the user clicks it again. Want to be able to close all of the muscle exercises. 
		var clickedElementIsHidden = clickedElement.next().css('display');

		if( clickedElementIsHidden == "block" ) {
			clickedElement.next().slideUp();
		} else {
			//close any other exercise containers that are open
			exerciseContainers.slideUp();


			//exercise stats to show element
			var elementToShow = clickedElement.next();
			//hide and show the element.
			elementToShow.slideToggle();
		}
		//end if







		/*
		*	Handle delete set functionailty
		*/


		var delete_set = {
			//this holds the UL of the set that was clicked - makes it easy to find the UL whenever you re-enter the html
			clickedUL: null,


			//function updates the delete modal form to have the correct hidden set ID
			update_delete_modal_form: function ( clickedButton ) {
				var clickedButton = clickedButton;
				//set id to delete
				var setID = clickedButton.closest('li').attr('data-set-id');
				var exerciseID = clickedButton.closest('li').attr('data-exercise-id');
				//set clickedUl variable
				this.clickedUL = clickedButton.closest('ul');

				//set the value of #modal-set-id and #modal-exericse-id to get it ready to be posted to the php file.
				$('#modal-set-id').val( setID );
				$('#modal-exercise-id').val( exerciseID );


				//return the button that was clicked to easily change the html in the view.
				return clickedButton;

			},//end delete_set

			//method deletes the set and updates the html in the appropriate UL.
			delete_set:  function() {
				var listItemContainer = this.clickedUL;
				//get the form to send
				var form = $('#delete-modal-form');
				
				$.post(BASE_URL + "ajax/submit_set", form.serialize() )
				.done(function(data){
					// console.log(data);
					//update the list items with the new data.
					listItemContainer.html( postSetLogic.buildListItems( data ) );
				}).
				fail(function(data){
					var stuff = JSON.stringify(data);
					$('#errors').html(stuff);
					console.log("errors - data ---- " + stuff);
				});

			}//end delete_set()
		};


		//stop normal functionality of delete form - stops it from refreshing the page.
		$("#delete-modal-form").submit(function(e) {
		    e.preventDefault();
		});


		//when a user clicks on a delete set button - update the modal with the correct form infromation.
		$(document).on('click', '.delete-set-btn', function() {
			var clickedButton = $(this);
			delete_set.update_delete_modal_form( clickedButton );
		});	//end on click

		$(document).on('click', '#delete-set-submit', function() {
			delete_set.delete_set();
			//close the modal
			$('#close-delete-set-modal').trigger('click');
		});	//end on click




		

		










		/*
		*	Page load functions to run
		*/

		// set_input_rest_time()


		



		
	});









	

	




});