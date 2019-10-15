<!DOCTYPE html>
<html lang="en">
<head>

<?php require('../db_connect.php'); 
session_start();

// Routes to login page if user is not logged in.
if (strcmp($_SESSION['loggedIn'], "yes") !== 0)
{
    header("Location: ../login");
}

include_once('nav.php');

?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 

<!-- Facebook logo font -->
<link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/356e745068.js"></script>

<link rel="stylesheet" type="text/css" href="../css/app.css">

</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-xl-10">
                <div class="create-post">
                    <h3 id="cp-tag">Create Post</h3>
                    <form action="createPost.php" method="POST">
                        <input class="cp-body" name="cp-body" type="text" placeholder="What's on your mind?">
                        <input class="post-button" type="submit" value="Post">
                    </form>
                </div>

                <!-- This is responsible for displaying all of the logged in users posts. -->
                <?php
                    include_once('userWall.php');
                ?>

            </div>
        </div>
    </div>

    </div>
    
    
</body>

<body>
