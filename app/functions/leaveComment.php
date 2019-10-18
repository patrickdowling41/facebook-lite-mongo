<?php 
include_once("../../../app/vendor/autoload.php"); 
session_start();

$body = $_POST['reply-field'];
$originalPostID = $_POST['post-id'];
$email = $_SESSION['email'];
date_default_timezone_set('Australia/Melbourne');


try {
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->Post;
    $insertOneResult = $collection->insertOne([
        'body' => $body,
        'posterEmail' => $email,
        'replyTo' => new MongoDB\BSON\ObjectId("$originalPostID"),
        'likes' => [],
        'timestamp' => new MongoDB\BSON\UTCDateTime((new DateTime($today))->getTimestamp()*1000)
    ]);
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

header('Location: ../index.php');
?>