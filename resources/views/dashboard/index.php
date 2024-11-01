<?php
wp_nonce_field( 'wpx_server_light' );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );

$columns = absint( get_current_screen()->get_columns() );

$columns_css = "";

if ( $columns ) {
  $columns_css = "columns-$columns";
}
?>

<input type="hidden" name="action" value="save_wpx_server_light" />

<div class="wpx-server-light wrap">

  <h1><?php _e( 'Server Information', WPXSERVERLIGHT_TEXTDOMAIN ) ?></h1>

  <div class="metabox-holder">
    <div class="meta-box-sortables">
      <div id="" class="postbox">
        <h3><?php _e( 'Host Name' ) ?><?php echo $info[ 'host_name' ][ 1 ] ?></h3>
        <div class="inside">
          <table class="wpxsrv-table" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
            <?php foreach ( $info as $key => $value ) : ?>
              <?php if ( empty( $value[ 0 ] ) ) {
                continue;
              } ?>
              <tr>
                <th><?php echo $value[ 0 ] ?></th>
                <td><?php echo $value[ 1 ] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="metabox-holder <?php echo $columns_css; ?>">
    <?php do_meta_boxes( get_current_screen(), 'full', '' ); ?>
  </div>

  <div class="metabox-holder">
    <div class='postbox-container wpxsl-left'>
      <?php do_meta_boxes( get_current_screen(), 'normal', '' ); ?>
    </div>
    <div class='postbox-container wpxsl-right'>
      <?php do_meta_boxes( get_current_screen(), 'side', '' ); ?>
    </div>
  </div>

</div>

<script type="text/javascript">
  //<![CDATA[
  jQuery( document ).ready( function()
  {
    // close postboxes that should be closed
    jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );

    // postboxes setup
    postboxes.add_postbox_toggles( '<?php echo get_current_screen()->id ?>' );
  } );
  //]]>
</script>