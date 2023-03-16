<?php

/**
 * 
 * Plugin Name: Leiverpress
 * Description: This is a Plugin for managing a motorcycle renting page
 * Version: 1.0.0
 * Text Domain: options-plugin
 * 
 */

if (!defined('ABSPATH')) {
   die('You are not allowed to be here!');
}



if (!class_exists('MyPlugin')) {

   class Leiverpress
   {

      public function __construct()
      {
         define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__)); //ist der Pfade,anders ist __FILE__, weil selber ist das myPlugin.php zum Beispiel
         //require_once(MY_PLUGIN_PATH . '/vendor/autoload.php'); //wäre der composer und die files die automatisch laden würden
         define('MY_PLUGIN_FILE', __FILE__);
      }

      public function initialize()
      {
         include_once MY_PLUGIN_PATH . 'lp-database/brand-database.php';

         include_once MY_PLUGIN_PATH . 'lp-database/bike-database.php';

         include_once MY_PLUGIN_PATH . 'lp-database/booking-database.php';
         
         include_once MY_PLUGIN_PATH . 'lp-includes/bike-search.php';
      }
   }


   $leiverplugin = new Leiverpress;
   $leiverplugin->initialize();
}
