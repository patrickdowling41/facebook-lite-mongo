<?php
session_start();
include_once("../../../app/vendor/autoload.php");

$email = $_SESSION['email'];
$screenName = $_POST['screen-name'];

try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;

    $result = $collection->updateOne(
        ['email' => $email],
        ['$set' => ['screenName' => $screenName]]
    );
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}
header('Location: ../settings.php');