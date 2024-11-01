<?php

namespace WPXServerLight\Modules;

use WPXServerLight\MorrisPHP\Morris;

class Disk extends Module
{

  protected $context = 'normal';

  public function boot()
  {
    $this->id    = 'disk';
    $this->title = __( 'Disk Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    $df = shell_exec( 'df -h' );
    $df = explode( "\n", $df );

    $result = false;

    if ( is_array( $df ) && count( $df ) >= 2 ) {

      array_shift( $df );

      $result = array();

      foreach ( $df as $line ) {
        if ( ! empty( $line ) ) {

          $segment = preg_split( '/\s+/', $line );

          $filesystem = esc_attr( $segment[ 0 ] );

          $result[ $filesystem ] = array(
            'size'        => $this->sanitize( $segment[ 1 ] ),
            'used'        => $this->sanitize( $segment[ 2 ] ),
            'available'   => $this->sanitize( $segment[ 3 ] ),
            'use_percent' => $segment[ 4 ],
          );
        }
      }
    }

    return $result;
  }

  /**
   * Return the value in GB.
   *
   * @brief Sanitize string GB
   *
   * @param string $value Disk amount.
   *
   * @return float
   */
  private function sanitize( $value )
  {

    $um = substr( $value, -1 );

    if ( ! empty( $um ) ) {

      $value = (float) trim( str_replace( '.', ',', $value ), $um );

      if ( 'G' == $um ) {
        $value = $value * 1024;
      }
    }

    return $value;
  }

  public function chart()
  {
    $data = [];

    foreach ( $this->values() as $type => $info ) {

      $data[] = array(
        'type'      => $type,
        'size'      => $info[ 'size' ],
        'available' => $info[ 'available' ],
        'used'      => $info[ 'used' ],
      );
    }

    return Morris::bar( $this->id . '-chart' )
                 ->data( $data )
                 ->xkey( array( 'type' ) )
                 ->ykeys( array( 'size', 'available', 'used' ) )
                 ->postUnits( ' MB' )
                 ->labels( array( __( 'Size' ), __( 'Available' ), __( 'Used' ) ) )
                 ->resize( true )
                 ->barOpacity( 0.8 )
                 ->stacked( false )
                 ->goalLineColors( array( '#333333', '#92b46f', '#ed5a61', ) )
                 ->barColors( array( '#333333', '#92b46f', '#ed5a61', ) );
  }

}