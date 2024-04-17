<?php

class Db
{
  private $mysqli;

  public function __construct()
  {
    // parses the settings file
    // $settings = parse_ini_file('settings_nacho.ini', true);
    $settings = parse_ini_file('settings_stef.ini', true);

    // starts the connection to the database
    $this->mysqli = new mysqli(
      $settings['database']['host'],
      $settings['database']['user'],
      $settings['database']['password'],
      $settings['database']['dbname']
    );
  }

  public function getConnection()
  {
    return $this->mysqli;
  }
}
