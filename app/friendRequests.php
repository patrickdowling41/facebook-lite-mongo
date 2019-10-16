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

<!-- jQuery import -->
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
</script>

<link rel="stylesheet" type="text/css" href="../css/app.css">

<?php
include_once('functions/confirmLoggedIn.php');
include_once('components/nav.php');
$email = $_SESSION['email'];
$count = 0;
?>
</head>
<body>
    <div class="container">
        <div class="row">
            <?php
            $getFriendDetails = "SELECT fu.email as email, fu.screenName as screenName, ur.requestID as requestID
            FROM FACEBOOKUSER fu
            LEFT JOIN USERREQUEST ur
            ON ur.email = fu.email
            WHERE ur.requestID IN
            (
                SELECT requestID
                FROM USERREQUEST
                WHERE email like :bv_email
                AND sentOrReceived like 'receiver'
            )
            AND ur.EMAIL NOT LIKE :bv_email";
            $stid = oci_parse($conn, $getFriendDetails);
            oci_bind_by_name($stid, ":bv_email", $email);
            oci_execute($stid);
            while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
            {
                $count++;
                ?>
                <!-- form to handle the friend request. will either accept or decline depending on the submission button selected -->
                <form action="functions/handleFriendRequest.php" method="POST">
                    <?php
                    echo '<h3 class="friend-screenName">'.$row['SCREENNAME'].'</h3>';
                    echo '<input class="friend-email" type="hidden" name="friend-email" value="'.$row['EMAIL'].'">';
                    echo '<input class="friend-requestID" type="hidden" name="friend-requestID" value="'.$row['REQUESTID'].'">';
                    ?>
                    <button class="btn btn-danger" type="submit" name="task" value="decline">Decline</button>
                    <button class="btn btn-success" type="submit" name="task" value="accept">Accept</button>
                </form> 
                <?php
            }
            // only occurs if no friend requests are found
            if ($count == 0)
            {
                echo '<h3>No pending friend invites</h3>';
            }
        ?>
        </div>
    </div>
</body>