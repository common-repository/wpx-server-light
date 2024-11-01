<?php

namespace WPXServerLight\Modules;

use WPXServerLight\MorrisPHP\Morris;

class RAM extends Module
{

  protected $context = 'side';

  public function boot()
  {
    $this->id    = 'ram';
    $this->title = __( 'RAM Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    $df = shell_exec( 'free -m | grep -E "(Mem|Swap)" | awk \'{print $1, $2, $3, $4}\'' );
    $df = explode( "\n", $df );

    $result = false;

    if ( is_array( $df ) && count( $df ) >= 2 ) {

      $result = array();

      foreach ( $df as $line ) {
        if ( ! empty( $line ) ) {

          $segment = preg_split( '/\s+/', $line );

          $type = trim( $segment[ 0 ], " :" );

          $result[ $type ] = array(
            'total' => (int) $segment[ 1 ],
            'used'  => (int) $segment[ 2 ],
            'free'  => (int) $segment[ 3 ],
          );
        }
      }
    }

    return $result;
  }

  public function chart()
  {
    $data = [];

    foreach ( $this->values() as $type => $info ) {

      $data[] = array(
        'type' => $type,
        'used' => $info[ 'used' ],
        'free' => $info[ 'free' ],
      );
    }

    return Morris::bar( $this->id . '-chart' )
                 ->data( $data )
                 ->xkey( array( 'type' ) )
                 ->ykeys( array( 'used', 'free' ) )
                 ->postUnits( ' MB' )
                 ->labels( array( __( 'Used' ), __( 'Free' ) ) )
                 ->resize( true )
                 ->barOpacity( 0.8 )
                 ->stacked( true )
                 ->goalLineColors( array( '#ed5a61', '#92b46f' ) )
                 ->barColors( array( '#ed5a61', '#92b46f' ) );

  }

}