<?php

namespace WPXServerLight\Modules;

use WPXServerLight\MorrisPHP\Morris;

class Network extends Module
{

  protected $context = 'normal';

  public function boot()
  {
    $this->id    = 'network';
    $this->title = __( 'Network Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    $ethernet = array();

    $output = `netstat -i | grep -v -E '(Iface|Interface)' | awk '{print $1","$4","$8}'`;

    $lines = explode( "\n", $output );
    foreach ( $lines as $line ) {
      $line = explode( ',', $line );
      if ( count( $line ) < 3 ) {
        continue;
      }
      $ethernet[ $line[ 0 ] ] = array( 'receive' => intval( $line[ 1 ] ), 'transfer' => intval( $line[ 2 ] ) );
    }

    return $ethernet;
  }

  public function chart()
  {
    $data = [];

    foreach ( $this->values() as $type => $info ) {

      $data[] = array(
        'interface' => $type,
        'receive'   => $info[ 'receive' ],
        'transfer'  => $info[ 'transfer' ],
      );
    }

    return Morris::bar( $this->id . '-chart' )
                 ->data( $data )
                 ->xkey( array( 'interface' ) )
                 ->ykeys( array( 'receive', 'transfer' ) )
                 ->labels( array( __( 'Receive' ), __( 'Transfer' ) ) )
                 ->resize( true )
                 ->barOpacity( 0.8 )
                 ->stacked( false )
                 ->goalLineColors( array( '#ed5a61', '#92b46f' ) )
                 ->barColors( array( '#ed5a61', '#92b46f' ) );

  }

}