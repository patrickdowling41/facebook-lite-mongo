<?php 
session_start();

include_once("../../../app/vendor/autoload.php");

include_once('../functions/confirmLoggedIn.php');

$body = $_POST['cp-body'];
$email = $_SESSION['email'];

$timestamp = Date("<YYYY-mm-ddTHH:MM:ss>");

try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->Post;
    $insertOneResult = $collection->insertOne([
        'body' => $body,
        'posterEmail' => $email,
        'timestamp' => $timestamp
    ]);
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

header("Location: ../index.php");

?>
