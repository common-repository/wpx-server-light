<?php

$output = shell_exec( "ip -oneline link show | awk '{print $2}' | sed 's/://'" );

if ( ! $output ) { // It didn't work with "ip" , so we do it with ifconfig
  $output     = `ifconfig | grep "Link encap" | awk '{ print $1 }'`;
  $interfaces = explode( "\n", $output );
  $output     = `ifconfig | grep "inet addr" | awk '{ print $2 }' | sed 's/addr://'`;
  $addreses   = explode( "\n", $output );
  $output     = trim( $output, " \n" );

  $values = array_combine( $interfaces, $addreses );
}
// Loop over the interface we found out with ip to find the Ip
// The output looks like
// eth0,10.0.2.15 eth1,192.168.1.111 lo,127.0.0.1
// we need to parse the result
else {
  $output     = trim( $output, " \n" );
  $interfaces = explode( "\n", $output );
  $addreses   = array();
  foreach ( $interfaces as $interface ) {
    $output     = shell_exec( "ip -oneline -family inet addr show $interface | awk '{print $4}' | cut -d'/' -f1" );
    $addreses[] = $output;
  }
}

$values = array_combine( $interfaces, $addreses );

?>
<table class="wpxsrv-table" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th><?php _e( 'Interface' ) ?></th>
    <th><?php _e( 'IP' ) ?></th>
  </tr>
  </thead>

  <tbody>
  <?php foreach ( $values as $interface => $ip ) : ?>
    <tr>
      <th><?php echo $interface ?></th>
      <td><?php echo $ip ?></td>
    </tr>

  <?php endforeach; ?>

  </tbody>

</table>

<div id="network-chart" style="min-width: 400px">
  <?php echo $chart ?>
</div>