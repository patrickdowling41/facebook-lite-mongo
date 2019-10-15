<?php 
require('../db_connect.php');
session_start();

if (strcmp($_SESSION['loggedIn'], "yes") !== 0)
{
    header("Location: ../login");
}

$body = $_POST['cp-body'];
$email = $_SESSION['email'];
date_default_timezone_set('Australia/Melbourne');
$timeOfPost = date('d-m-y H:i');

$addLike = "INSERT INTO POST (
    bodyText,
    posterEmail,
    postTime
)
VALUES
(
    :bv_body,
    :bv_email,
    TO_DATE(:bv_timeOfPost, 'dd-mm-yy hh24:mi')
)";

$stid = oci_parse($conn, $addLike);

oci_bind_by_name($stid, ':bv_body', $body);
oci_bind_by_name($stid, ':bv_email', $email);
oci_bind_by_name($stid, ':bv_timeOfPost', $timeOfPost);

oci_execute($stid);

echo $timeOfPost;

// header("Location: index.php");

?>
