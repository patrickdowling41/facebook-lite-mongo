<?php session_start();
include_once("../../../app/vendor/autoload.php");
$senderEmail = $_POST['friend-email'];
$friendEmail = $_SESSION['email'];
$requestID = $_POST['friend-requestID'];
// when friendship is accepted, create the friendship
if (strcmp($_POST['task'], 'accept') == 0)
{
    addFriend($senderEmail, $friendEmail);
} 
// request is deleted regardless of whether the friendship is accepted or declined.
deleteRequest($senderEmail, $friendEmail);
function addFriend($senderEmail, $friendEmail)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;
    
        $result = $collection->updateOne(
            ['email' => $senderEmail],
            ['$addToSet' => ['friends' => ['email' => $friendEmail]]]
        );

        $result = $collection->updateOne(
            ['email' => $friendEmail],
            ['$addToSet' => ['friends' => ['email' => $senderEmail]]]
        );  
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
function deleteRequest($senderEmail, $friendEmail)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;
    
        $result = $collection->updateOne(
            ['email' => $senderEmail],
            ['$pull' => ['friendsInvited' => ['email' => $friendEmail]]]
        );

        $result = $collection->updateOne(
            ['email' => $friendEmail],
            ['$pull' => ['friendRequests' => ['email' => $senderEmail]]]
        );  
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
header('Location: ../friendRequests.php');