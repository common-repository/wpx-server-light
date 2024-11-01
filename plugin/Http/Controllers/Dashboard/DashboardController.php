<?php

namespace WPXServerLight\Http\Controllers\Dashboard;

use WPXServerLight\Http\Controllers\Controller;
use WPXServerLight\MorrisPHP\Morris;

class DashboardController extends Controller
{
  public function load()
  {
    // meta box
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

    // morris
    Morris::enqueue();

    $screen = get_current_screen();

    $modules = [
      '\WPXServerLight\Modules\CPU',
      '\WPXServerLight\Modules\RAM',
      '\WPXServerLight\Modules\Process',
      '\WPXServerLight\Modules\Disk',
      '\WPXServerLight\Modules\Software',
      '\WPXServerLight\Modules\Network',
      '\WPXServerLight\Modules\IOStat',
    ];

    foreach ( $modules as $className ) {
      $instance = new $className( $screen );
    }
  }

  public function index()
  {
    return WPXServerLight()
      ->view( 'dashboard.index' )
      ->with( 'info', $this->getServerInfo() )
      ->withAdminStyles( 'wpxsl-dashboard' );
  }

  protected function getServerInfo()
  {
    // Updatime
    $total_uptime_diff = time() - `cut -d. -f1 /proc/uptime`;
    $uptime            = $this->elapsedString( time(), true, $total_uptime_diff );

    // Caching
    $info = ''; //get_site_transient( 'wpxsrv_server_info' );

    // Check if rebuild
    if ( empty( $info ) ) {
      $info = array(
        'host_name'   => [ '', `hostname` ],
        'ip_address'  => [ __( 'IP Address' ), `curl -s http://whatismyip.akamai.com/` ],
        'os'          => [ __( 'OS' ), `uname -sr` ],
        'core'        => [ __( 'Core' ), `grep -c ^processor /proc/cpuinfo` ],
        'ram'         => [ __( 'RAM' ), `free -m | grep Mem | awk '{print $2}'` ],
        'cpu'         => [ __( 'CPU' ), `cat /proc/cpuinfo | grep "model name" | awk '{print $4,$5,$6,$7}'` ],
        'php_modules' => [ __( 'PHP Modules' ), implode( ', ', get_loaded_extensions() ) ],
      );

      set_site_transient( 'wpxsrv_server_info', $info, HOUR_IN_SECONDS );

    }

    // Add ever uptime
    $info[ 'uptime' ] = array( __( 'Uptime' ), $uptime );

    return $info;
  }

  /**
   * This method is similar to WordPress human_time_diff(), with the different that every amount is display.
   * For example if WordPress human_time_diff() display '10 hours', this method display '9 Hours 47 Minutes 56 Seconds'.
   *
   * @brief More readable time elapsed
   *
   * @param int    $timestamp  Date from elapsed
   * @param bool   $hide_empty Optional. If TRUE '0 Year' will not return. Default TRUE.
   * @param int    $to         Optional. Date to elapsed. If empty time() is used
   * @param string $separator  Optional. Separator, default ', '.
   *
   * @return string
   */

  protected function elapsedString( $timestamp, $hide_empty = true, $to = 0, $separator = ', ' )
  {
    // If no $to then now
    if ( empty( $to ) ) {
      $to = time();
    }

    // Key and string output
    $useful = array(
      'y' => array( __( 'Year' ), __( 'Years' ) ),
      'm' => array( __( 'Month' ), __( 'Months' ) ),
      'd' => array( __( 'Day' ), __( 'Days' ) ),
      'h' => array( __( 'Hour' ), __( 'Hours' ) ),
      'i' => array( __( 'Minute' ), __( 'Minutes' ) ),
      's' => array( __( 'Second' ), __( 'Seconds' ) ),
    );

    $matrix = array(
      'y' => array( 12 * 30 * 24 * 60 * 60, 12 ),
      'm' => array( 30 * 24 * 60 * 60, 30 ),
      'd' => array( 24 * 60 * 60, 24 ),
      'h' => array( 60 * 60, 60 ),
      'i' => array( 60, 60 ),
      's' => array( 1, 60 ),
    );

    $diff = $timestamp - $to;

    $stack = array();
    foreach ( $useful as $w => $strings ) {

      $value = floor( $diff / $matrix[ $w ][ 0 ] ) % $matrix[ $w ][ 1 ];

      if ( empty( $value ) || $value < 0 ) {
        if ( $hide_empty ) {
          continue;
        }
        $value = 0;
      }

      $stack[] = sprintf( '%s %s', $value, _n( $strings[ 0 ], $strings[ 1 ], $value ) );
    }

    return implode( $separator, $stack );

  }


}