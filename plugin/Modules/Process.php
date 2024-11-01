<?php

namespace WPXServerLight\Modules;

class Process extends Module
{

  protected $context = 'full';

  public function boot()
  {
    $this->id    = 'process';
    $this->title = __( 'Process Information', WPXSERVERLIGHT_TEXTDOMAIN );
  }

  public function values()
  {
    $process = `ps -eo pcpu,pmem,pid,user,args,time,start | grep -v '\[' | sort -k 1 -r | head -30 | awk '{print $4,$3,$1,$2,$7,$6,$5}'`;

    // Get lines
    $lines = explode( "\n", $process );

    // Skip the first line
    array_shift( $lines );

    // Prepare results
    $results = array();

    foreach ( $lines as $line ) {

      // Get columns
      $line = explode( ' ', $line );

      // Stability
      if ( count( $line ) < 6 ) {
        continue;
      }

      if ( empty( $results[ $line[6] ] ) ) {
        $results[ $line[6] ] = array_combine( array(
            'user',
            'pid',
            '%cpu',
            '%mem',
            'start',
            'time',
            'command'
          ), $line );
      }
      else {
        $results[ $line[6] ]['%cpu'] += $line[2];
        $results[ $line[6] ]['%mem'] += $line[3];
      }

    }

    return $results;
  }

  public function chart()
  {
    return $this->values();
  }

}