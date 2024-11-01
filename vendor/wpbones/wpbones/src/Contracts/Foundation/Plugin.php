<?php

namespace WPXServerLight\WPBones\Contracts\Foundation;

use WPXServerLight\WPBones\Contracts\Container\Container;

interface Plugin extends Container {

  /**
   * Get the base path of the Plugin installation.
   *
   * @return string
   */
  public function getBasePath();
}