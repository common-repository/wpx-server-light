<?php

namespace WPXServerLight\Modules;

abstract class Module
{
  protected $id = '';

  protected $title = '';

  protected $context = 'normal';

  protected $priority = 'default';

  protected $screen;

  abstract public function boot();

  abstract public function chart();

  public function view()
  {
    echo WPXServerLight()
      ->view( "dashboard.{$this->id}" )
      ->with( 'chart', $this->chart() );
  }

  public function __construct( $screen )
  {
    $this->screen = $screen;

    $this->boot();

    add_meta_box( $this->id,
                  $this->title,
                  [ $this, 'view' ],
                  $this->screen,
                  $this->context,
                  $this->priority
    );
  }


  public function __get( $name )
  {
    $method = "get" . ucfirst( $name ) . 'Attribute';

    if ( method_exists( $this, $method ) ) {
      return $this->$method();
    }
  }

}