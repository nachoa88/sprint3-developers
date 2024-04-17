<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Db
{
  private $db;
  // No se si es necesario tener el cliente, pero lo dejo por si acaso.
  private $client;

  public function __construct()
  {
    // Parses the settings file
    $settings = parse_ini_file('settings_nacho.ini', true);
    // $settings = parse_ini_file('settings_stef.ini', true);

    // Starts the connection to the database
    $this->client = new MongoDB\Client("mongodb://" . $settings['database']['host'] . ":27017");

    // Select a database
    $this->db = $this->client->selectDatabase($settings['database']['dbname']);
  }

  public function getConnection()
  {
    return $this->db;
  }

  // Si no es necesario, borrar.
  public function getClient()
  {
    return $this->client;
  }
}
