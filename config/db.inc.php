<?php

class Db
{
  private $db;

  public function __construct()
  {
    // Starts the connection to the database
    // $client = new MongoDB\Client("mongodb://mongodb:27017");
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Select a database
    $this->db = $client->tasks;
  }

  public function getConnection()
  {
    return $this->db;
  }
}
