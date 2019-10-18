<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>

<title>Facebook-lite</title>
<link rel='shortcut icon' type='image/svg' href='../img/favicon.svg' />

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 

<script src="https://kit.fontawesome.com/356e745068.js"></script>

<link rel="stylesheet" type="text/css" href="../css/app.css">

</head>

<?php
include_once('components/nav.php');
include_once("../../app/vendor/autoload.php");

$search = $_POST['friend-search'];
$userEmail = $_SESSION['email'];

include_once('functions/confirmLoggedIn.php');

$count=0;

// responds all search results matching the screen name or email, not showing the logged in user however
try {
    
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;

    $cursor = $collection->find([
        '$or' => [
            ['email' => $search],
            ['screenName' => $search],
        ],
    ]);
    // display all docs that match the search condition
    foreach ($cursor as $document) 
    {
        $count++;
        ?>
        
        <div class="container">
            <div class="user-component">
            <h1>Search Results</h1>
            <!-- form that displays each user and allows current user to add them as friend -->
            <form action="functions/sendFriendRequest.php" method="POST">
                <div class="row">
                    <div class="col-xs-1">
                        <i class="far fa-user-circle fa-3x"></i>
                    </div>
                    <div class="col-lg-5">
                        <?php  
                        echo '<h3 class="search-username">'.$document->screenName.'</h3>';
                        echo '<p class="search-email">'.$document->email.'</p>';
                        if(isset($document->location)=== true)
                        {
                            echo '<div class="search-location">'.$document->city.', '.$document->country.'</div>';
                        }
                        echo '<input name="friend-email" type="hidden" value="'.$document->email.'">';
                        ?>
                    </div>
                    <div class="col-lg-5">
                        <?php if (strcmp($document->email, $userEmail) === 0)
                        {
                            echo '<button type="submit" disabled class="btn btn-light">+ Add Friend</button>';
                        }
                        else
                        {
                            echo '<button type="submit" class="btn btn-light">+ Add Friend</button>';
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }

    if ($count === 0)
    {
        echo '<h3 class="text-center">No matching users</h3>';
    }
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

?>