<?php

namespace WPXServerLight\Modules;

use WPXServerLight\MorrisPHP\Morris;

class IOStat extends Module
{

  protected $context = 'side';

  public function boot()
  {
    $this->id    = 'iostat';
    $this->title = __( 'I/O Stat Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    // Check for iostat
    $output = `which iostat`;

    if ( empty( $output ) || is_null( $output ) ) {
      return [];
    }

    //Sample return:
    //Linux 2.6.32-358.23.2.el6.x86_64 (vagrant-centos64.vagrantup.com) 	04/10/2014 	_x86_64_	(1 CPU)

    //avg-cpu:  %user   %nice %system %iowait  %steal   %idle
    //0.99    0.00    4.50    1.06    0.00   93.45

    //Device:            tps   Blk_read/s   Blk_wrtn/s   Blk_read   Blk_wrtn
    //sda              13.01      3033.87         9.16   62978242     190192
    $output         = `iostat`;
    $number_of_core = intval( `/bin/grep -c processor /proc/cpuinfo` );

    $lines = explode( "\n", $output );

    // We should have more than  4 lines
    if ( ! is_array( $lines ) || sizeof( $lines ) < 4 ) {
      return false;
    }
    $avg_cpu = preg_split( "/\s+/", $lines[ 3 ] );
    $metric  = array(
      'user'    => floatval( $avg_cpu[ 0 ] ) * $number_of_core,
      'system'  => floatval( $avg_cpu[ 2 ] ) * $number_of_core,
      'io_wait' => floatval( $avg_cpu[ 3 ] ) * $number_of_core,
      'other'   => 100 - ( $avg_cpu[ 0 ] + $avg_cpu[ 2 ] + $avg_cpu[ 3 ] )
    );

    return $metric;
  }

  public function chart()
  {
    $data = [];

    foreach ( $this->values() as $label => $value ) {
      $data[] = array(
        'label' => ucfirst( $label ),
        'value' => $value,
      );
    }

    return Morris::donut( $this->id . '-chart' )
                 ->formatter( 'return y + "%";' )
                 ->data( $data );
  }

}