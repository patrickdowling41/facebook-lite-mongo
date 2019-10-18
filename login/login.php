<?php session_start();
include_once("../../app/vendor/autoload.php");

$_SESSION['loggedIn'] = 0;

// returns if username or password aren't set
if (!(isset($_POST['login-email'])) || !(isset($_POST['login-password'])))
{
    header("Location: index.php");
}

$email = $_POST['login-email'];
$passwordHash = hash("sha256", $_POST['login-password']);

try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;
    $result = $collection->find(array(
        'email' => $email,
        'passwordHash' => $passwordHash
    ));

    foreach($result as $document)
    {  
        $_SESSION["loggedIn"] = 1;
    }

}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

if ($_SESSION["loggedIn"] === 1)
{
    // redirects to the app once logged in correctly.
    $_SESSION['email'] = $email;
    header('Location: ../app');
}
else
{
    // loads a login form to allow login from a seperate menu to indicate login was previously unsuccessful
    include_once('index.php');
}