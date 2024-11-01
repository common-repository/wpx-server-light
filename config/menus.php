<?php

/*
|--------------------------------------------------------------------------
| Plugin Menus routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the menu routes for a plugin.
| In this context the route are the menu link.
|
*/

return [
  'wpx_server_light_slug_menu' => [
    "menu_title" => __( 'Server', WPXSERVERLIGHT_TEXTDOMAIN ),
    'capability' => 'manage_options',
    'icon'       => 'dashicons-info',
    'items'      => [
      [
        "menu_title" => __( 'Overview', WPXSERVERLIGHT_TEXTDOMAIN ),
        'capability' => 'manage_options',
        'route'      => [
          'load' => 'Dashboard\DashboardController@load',
          'get'  => 'Dashboard\DashboardController@index'
        ],
      ],
    ]
  ]
];
