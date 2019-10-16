<?php 
require('../db_connect.php');
session_start();

$body = $_POST['reply-field'];
$originalPostID = $_POST['post-id'];
$email = $_SESSION['email'];
date_default_timezone_set('Australia/Melbourne');
$timestamp = date('d-m-y H:i');

$reply = "INSERT INTO POST (
    bodyText,
    posterEmail,
    postTime,
    originalPostID,
    replyToID
)
VALUES
(
    :bv_bodyText,
    :bv_email,
    TO_DATE(:bv_timestamp, 'dd-mm-yy hh24:mi'),
    :bv_originalPostID,
    :bv_originalPostID
)";

$stid = oci_parse($conn, $reply);

oci_bind_by_name($stid, ":bv_bodyText", $body);
oci_bind_by_name($stid, ":bv_email", $email);
oci_bind_by_name($stid, ":bv_originalPostID", $originalPostID);
oci_bind_by_name($stid, ":bv_timestamp", $timestamp);

oci_execute($stid);

header('Location: ../app/index.php');
?>