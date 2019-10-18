<?php 
session_start();
include_once("../../../app/vendor/autoload.php"); 

$postID = $_POST['post-id'];
$email = $_SESSION['email'];

try {
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->Post;
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId("$postID")],
        ['$addToSet' => ['likes' => ['email' => $email]]
    ]);  
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

header('Location: ../');

?>