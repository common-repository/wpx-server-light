<div id="process-chart">
  <table class="wpxsrv-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th><?php _e( 'User' ) ?></th>
        <th><?php _e( 'PID' ) ?></th>
        <th><?php _e( '% CPU' ) ?></th>
        <th><?php _e( '% MEM' ) ?></th>
        <th><?php _e( 'Start' ) ?></th>
        <th><?php _e( 'Time' ) ?></th>
        <th><?php _e( 'Command' ) ?></th>
      </tr>
    </thead>

    <tbody>
    <?php foreach( $chart as $line => $column ) : ?>
      <tr>
        <th><?php echo $column['user'] ?></th>
        <td><?php echo $column['pid'] ?></td>
        <td><?php echo $column['%cpu'] ?></td>
        <td><?php echo $column['%mem'] ?></td>
        <td><?php echo $column['start'] ?></td>
        <td><?php echo $column['time'] ?></td>
        <td><?php echo $column['command'] ?></td>
      </tr>

    <?php endforeach; ?>

    </tbody>

  </table>
</div>