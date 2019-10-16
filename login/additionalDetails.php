<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    // sets value to no if it's undefined.
    if (isset($_SESSION["loggedIn"] ) === 0)
    {
        $_SESSION["loggedIn"] = 0;
    }
    // moves user directly to app if logged in already
    if ($_SESSION["loggedIn"] === 1)
    {
        header("Location: ../app");
    }
    ?>

    <title>Facebook | Sign up</title>
    <link rel='shortcut icon' type='image/svg' href='../img/favicon.svg' />
    
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

    <link rel="stylesheet" type="text/css" href="../css/login.css">

</head>
<body>

<?php include_once('components/nav.php');?>

<div class="container">
    <div class="row page-content">
        <div class="span-page col-lg-6">
            <h1>Customise your profile</h1>
            <!-- simple form for all of the additional fields that aren't compulsory. -->
            <form action="functions/completeSignup.php" method="POST">
                <div class="title-tag">Screen name</div>
                <input class="signup-ad" type="text" name="screenName" placeholder="Screen name">
                <br>
                <div class="title-tag">Location</div>
                <input class="signup-ad" type="text" name="city" placeholder="City">
                <input class="signup-ad" type="text" name="country" placeholder="Country">
                <br>
                <div class="title-tag">Status</div>
                <input class="signup-ad" type="text" name="status" placeholder="Status">
                <br>
                <div class="title-tag">Profile Visbility</div>
                <select class="settings-input" name="visibility">
                    <option value="select" selected disabled>Select one</option>
                    <option value="private">Private</option>
                    <option value="friends only">Friends only</option>
                    <option value="public">Public</option>
                </select>
                <br>
                <div class="inline">
                    <button class="skip-ad btn btn-danger" type="submit" name="ad" value="skip-ad">Skip</button>
                    <button class="complete-ad btn btn-success" type="submit" name="ad" value="complete-ad">Complete sign up</button>
                </div>                
            </form>
        </div>
    </div>
</div>

</body>

</html>