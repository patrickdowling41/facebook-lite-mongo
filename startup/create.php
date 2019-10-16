<?php
require('connection.php');
include_once("../../app/vendor/autoload.php");
try {

  // $client = new MongoDB\Client("mongodb://mongo:27017");

  $collection = $client->MyDB->MyUsersCollection;

  $insertOneResult = $collection->insertOne([
      'username' => 'new-admin',
      'email' => 'admin@example.com',
      'name' => 'Admin User',
  ]);
  echo "Insertion Completed.<BR>";


  $insertManyResult = $collection->insertMany([
   [
    'username' => 'admin',
    'email' => 'admin@example.com',
    'name' => 'Admin User',
  ],
  [
    'username' => 'admin1',
    'email' => 'admin1@example.com',
    'name' => 'Admin User 2',
  ]]);
    echo "Check point 4<BR>";

}
catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);

    echo "The $filename script has experienced an error.\n";
    echo "It failed with the following exception:\n";

    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";
}

?>
