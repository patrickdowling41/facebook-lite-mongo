<?php
session_start();
include_once("../../../app/vendor/autoload.php");

// if the user select skip, redirect to the home
if (strcmp($_POST['ad'], 'skip-ad') == 0)
{
    header('Location: ../index.php');
} 
// if user selected to input their information, update their user
else
{
    $email = $_SESSION['signupEmail'];
    // if either of them are unset, we don't want to alter the users location
    if (isset($_POST['country']) == true && isset($_POST['city']) == true)
    {
        updateLocation($email, $_POST['country'], $_POST['city']);
    }
    if (isset($_POST['status']))
    {
        updateStatus($email, $_POST['status']);
    }
    if (isset($_POST['visibility']))
    {
        updateVisibility($email, $_POST['visibility']);
    }
    if (isset($_POST['screenName']))
    {
        updateScreenName($email, $_POST['screenName']);
    }

}
function updateLocation($email, $country, $city)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;

        $result = $collection->updateOne(
            ['email' => $email],
            ['$set' => ['location' => ['city' => $city, 'country' => $country]]]
            );
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
function updateStatus($email, $status)
{  
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;

        $result = $collection->updateOne(
            ['email' => $email],
            ['$set' => ['status' => $status]]
        );
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
function updateVisibility($email, $visbility)
{  
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");
    
        $collection = $client->Assignment2->FacebookUser;

        $result = $collection->updateOne(
            ['email' => $email],
            ['$set' => ['visibility' => $visbility]]
        );
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
function updateScreenName($email, $screenName)
{  
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
}

?>

<script>
    window.onload = () => { 
        window.location.replace("../index.php");
    }
</script>