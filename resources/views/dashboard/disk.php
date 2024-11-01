<?php
// Check for iostat
$output = `which iostat`;

if ( empty( $output ) || is_null( $output ) ) : ?>

  <div class="wpxsl-notice-warning">
    <?php _e( 'The program \'iostat\' is currently not installed.<br/>To run \'iostat\' please ask your administrator to install the package \'sysstat\'' ) ?>
  </div>


<?php else :


  // Get ethernet info
  $values = $this->iostat();

  //WPXtreme::log( $values );

  ?>
  <table class="wpxsrv-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
      <th><?php _e( 'Disk' ) ?></th>
      <th><?php _e( 'Read/Write' ) ?></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ( $values as $disk => $info ) : ?>
      <tr>
        <th><?php echo $disk ?></th>
        <td><?php echo $info[ 'read' ] ?> / <?php echo $info[ 'write' ] ?></td>
      </tr>

    <?php endforeach; ?>

    </tbody>

  </table>

  <?php

endif;
?>

<div id="disk-chart" style="min-width: 400px">
  <?php echo $chart ?>
</div>