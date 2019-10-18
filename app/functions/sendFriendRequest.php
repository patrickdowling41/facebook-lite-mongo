<?php
session_start();
include_once("../../../app/vendor/autoload.php");

$senderEmail = $_SESSION['email'];
$friendEmail = $_POST['friend-email'];

// checks to make sure the two aren't already friends
if (!existingFriendship($senderEmail, $friendEmail))
{
    sendFriendRequest($senderEmail, $friendEmail);
}

header('Location: ../index.php');

function existingFriendship($senderEmail, $friendEmail)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;
    
        $result = $collection->findOne(
            ['email' => $senderEmail],
            ['friends' => ['email' => $friendEmail]]
        );

        if (isset($result->email))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}

function sendFriendRequest($senderEmail, $friendEmail)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;
    
        $result = $collection->updateOne(
            ['email' => $senderEmail],
            ['$addToSet' => ['friendsInvited' => ['email' => $friendEmail]]]
        );  

        $result = $collection->updateOne(
            ['email' => $friendEmail],
            ['$addToSet' => ['friendRequests' => ['email' => $senderEmail]]]
        );  
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
?>