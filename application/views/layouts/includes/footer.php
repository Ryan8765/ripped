



    

    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/foundation.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/helpers.js"></script>
    <script>
      $(document).foundation();
    </script>

    <!-- custom javascript file to include - loaded via controller -->
    <?php if( isset( $javascript ) ): ?>
        <script src="<?php echo base_url(); ?>assets/js/<?php echo $javascript; ?>"></script>
    <?php endif; ?>
  </body>
</html>