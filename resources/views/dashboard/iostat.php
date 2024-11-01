<?php
// Check for iostat
$output = `which iostat`;

if ( empty( $output ) || is_null( $output ) ) : ?>

  <div class="wpxsl-notice-warning">
    <?php _e( 'The program \'iostat\' is currently not installed.<br/>To run \'iostat\' please ask your administrator to install the package \'sysstat\'' ) ?>
  </div>
<?php else : ?>

<div id="iostat-chart">
  <?php echo $chart ?>
</div>

<?php endif;