<?php

namespace WPXServerLight\Modules;

use WPXServerLight\MorrisPHP\Morris;

class CPU extends Module
{

  public function boot()
  {
    $this->id    = 'cpu';
    $this->title = __( 'CPU Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    // Get number of core
    $number_of_core = intval( shell_exec( '/bin/grep -c processor /proc/cpuinfo' ) );
    $load_avg       = shell_exec( 'cat /proc/loadavg | /usr/bin/awk \'{print $1,$2,$3}\'' );
    $load_avg       = explode( ' ', $load_avg );

    $result = false;

    if ( count( $load_avg ) > 2 ) {

      $load_times = array( '1 min', '5 mins', '15 mins' );

      $result = array();

      foreach ( $load_avg as $value ) {

        $result[ current( $load_times ) ] = array(
          'percentage' => round( $value * 100 / $number_of_core, 2 ),
          'value'      => $value,
        );

        next( $load_times );
      }
    }

    return $result;
  }

  public function chart()
  {
    $data = [];

    foreach ( $this->values() as $type => $info ) {
      $data[] = [
        'duration'   => $type,
        'percentage' => $info[ 'percentage' ],
      ];
    }

    return Morris::bar( $this->id . '-chart' )
                 ->data( $data )
                 ->xkey( [ 'duration' ] )
                 ->ykeys( [ 'percentage' ] )
                 ->labels( [ 'percentage' ] )
                 ->postUnits( '%' )
                 ->resize( true )
                 ->barOpacity( 0.8 )
                 ->stacked( false )
                 ->goalLineColors( [ '#ed5a61', '#92b46f', '#333333' ] )
                 ->barColors( [ '#ed5a61', '#92b46f', '#333333' ] );
  }

}