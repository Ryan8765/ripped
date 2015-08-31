<!-- the reason you can use "$this" here without including CI_Controller is because this view is being loaded within another view where CI_Controller is included.  Check out controllers/products.php for the details of where it is already loaded. -->

<!-- This file loads all content -->
<?php $this->load->view('layouts/includes/header.php'); ?>

	<!-- load the main content of the view -->
	<?php $this->load->view($main_content); ?>


<?php $this->load->view('layouts/includes/footer.php'); ?>