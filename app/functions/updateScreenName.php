<?php

require('../../db_connect.php');
session_start();

$email = $_SESSION['email'];
$screenName = $_POST['screen-name'];

if (isset($screenName))
{
    $updateUser = "UPDATE FACEBOOKUSER
    SET screenName = :bv_screenName
    WHERE email like :bv_email";

    $stid = oci_parse($conn, $updateUser);

    oci_bind_by_name($stid, ":bv_email", $email);
    oci_bind_by_name($stid, ":bv_screenName", $screenName);
    
    oci_execute($stid);
}
oci_close($conn);
header('Location: ../settings.php');