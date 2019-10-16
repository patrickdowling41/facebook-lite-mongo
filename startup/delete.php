<?php

include_once("../../app/vendor/autoload.php");
try {
  $client = new MongoDB\Client("mongodb://mongo:27017");

  $collection = $client->MyDB->MyUsersCollection;

// UPDATE table SET field = value WHERE field2 = value2
$deleteResult = $collection->deleteMany(['username' => 'dba']);

echo "Delete Completed.<BR>";
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
