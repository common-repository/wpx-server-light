<?php

namespace WPXServerLight\WPBones\Html;

class Html
{

  protected static $htmlTags = [
    'a'        => '\WPXServerLight\WPBones\Html\HtmlTagA',
    'button'   => '\WPXServerLight\WPBones\Html\HtmlTagButton',
    'checkbox' => '\WPXServerLight\WPBones\Html\HtmlTagCheckbox',
    'datetime' => '\WPXServerLight\WPBones\Html\HtmlTagDatetime',
    'fieldset' => '\WPXServerLight\WPBones\Html\HtmlTagFieldSet',
    'form'     => '\WPXServerLight\WPBones\Html\HtmlTagForm',
    'input'    => '\WPXServerLight\WPBones\Html\HtmlTagInput',
    'label'    => '\WPXServerLight\WPBones\Html\HtmlTagLabel',
    'optgroup' => '\WPXServerLight\WPBones\Html\HtmlTagOptGroup',
    'option'   => '\WPXServerLight\WPBones\Html\HtmlTagOption',
    'select'   => '\WPXServerLight\WPBones\Html\HtmlTagSelect',
    'textarea' => '\WPXServerLight\WPBones\Html\HtmlTagTextArea',
  ];

  public static function __callStatic( $name, $arguments )
  {
    if ( in_array( $name, array_keys( self::$htmlTags ) ) ) {
      $args = ( isset( $arguments[ 0 ] ) && ! is_null( $arguments[ 0 ] ) ) ? $arguments[ 0 ] : [];

      return new self::$htmlTags[ $name ]( $args );
    }
  }
}