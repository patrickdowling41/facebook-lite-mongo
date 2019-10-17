<?php
session_start();
include_once("../../../app/vendor/autoload.php");

$email = $_SESSION['email'];

try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;

    $result = $collection->updateOne(
        ['email' => $email],
        ['$set' => ['location' => ['city' => $_POST['location-city'], 'country' => $_POST['location-country']]]]
        );
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}
header('Location: ../settings.php');
?>