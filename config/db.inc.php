<?php

/**
 * This file is used for creating a connection to the database
 */
 
// parses the settings file
// $settings = parse_ini_file('settings_nacho.ini', true);
$settings = parse_ini_file('settings_stef.ini', true);

// starts the connection to the database
$dbh = new PDO(
  sprintf(
    "%s:host=%s;dbname=%s",
    $settings['database']['driver'],
    $settings['database']['host'],
    $settings['database']['dbname']
  ),
  $settings['database']['user'],
  $settings['database']['password']
);

?>
