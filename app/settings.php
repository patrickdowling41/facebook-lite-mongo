<!DOCTYPE html>
<html lang="en">
<head>

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

<!-- jQuery import -->
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
</script>

<link rel="stylesheet" type="text/css" href="../css/app.css">

</head>

<?php include_once('../app/nav.php'); ?>

<div class="container">
    <div class="row">
        <h1>Your settings</h1>

        <form action="../functions/updateStatus.php" method="POST">
            <div class="col-md-6">
                <input class="settings-input" type="text" name="status" placeholder="Status">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

        <form action="../functions/updateDisplayName.php" method="POST">
            <div class="col-md-6">
                <input class="settings-input" type="text" name="display-name" placeholder="Display name">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

        <form action="../functions/updateLocation.php" method="POST">
            <div class="col-md-6">
                <input class="settings-input" type="text" name="location-city" placeholder="City">
                <input class="settings-input" type="text" name="location-country" placeholder="Country">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

        <form action="../functions/updateVisibility.php" method="POST">
            <div class="col-md-6">
                <select class="settings-input"name="display-name">
                    <option value="select" selected disabled required>Select one</option>
                    <option value="visibility-private">Private</option>
                    <option value="visibility-friends-only">Friends only</option>
                    <option value="visibility-public">Public</option>
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

