<?php session_start(); ?> 
 <?php

include_once('functions/confirmLoggedIn.php');
include_once('components/nav.php');
?>

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

<body>
    <div class="container">
        <div class="row">
            <div class="col-xl-10">
                <div class="create-post">
                    <h3 id="cp-tag">Create Post</h3>
                    <form action="functions/createPost.php" method="POST">
                        <input class="cp-body" name="cp-body" type="text" placeholder="What's on your mind?">
                        <input class="post-button" type="submit" value="Post">
                    </form>
                </div>

                <!-- This is responsible for displaying all of the logged in users posts. -->
                <?php
                // shows users wall as a component
                include_once('components/userWall.php');
                ?>
            </div>
        </div>
    </div>
</body>
