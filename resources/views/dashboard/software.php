<div id="software-chart">
  <table class="wpxsrv-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th><?php _e( 'Package' ) ?></th>
        <th><?php _e( 'Version' ) ?></th>
      </tr>
    </thead>

    <tbody>
    <?php foreach( $chart as $package => $version ) : ?>
      <tr class="<?php echo sanitize_title( $version ) ?>">
        <th><?php echo $package ?></th>
        <td><?php echo $version ?></td>
      </tr>

    <?php endforeach; ?>

    </tbody>

  </table>
</div>