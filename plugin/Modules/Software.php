<?php

namespace WPXServerLight\Modules;

class Software extends Module
{

  protected $context = 'side';

  public function boot()
  {
    $this->id    = 'software';
    $this->title = __( 'Software Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    $package = array(
      'php'    => '-v',
      'node'   => '-v',
      'mysql'  => '-V',
      'vim'    => '--version',
      'python' => '-V',
      'ruby'   => '-v',
      'java'   => '-version',
      'curl'   => '-V'
    );

    $cmds = [];

    foreach ( $package as $cmd => $version_query ) {
      if ( null == $cmds[ $cmd ] = shell_exec( "which $cmd" ) ) {
        $cmds[ $cmd ] = __( 'Not installed' );
        continue;
      }
      $version = shell_exec( "$cmd $version_query" );

      // Stability
      if ( is_null( $version ) ) {
        $version = __( 'Permission Denied' );
      }

      //WPXtreme::log( $version, $cmd );

      $version = explode( "\n", $version );
      if ( is_array( $version ) ) {
        $version = array_shift( $version );
      }

      $cmds[ $cmd ] = $version;
    }

    return $cmds;
  }

  public function chart()
  {
    return $this->values();
  }

}