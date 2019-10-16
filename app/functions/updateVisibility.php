<?php

require('../../db_connect.php');
session_start();

$email = $_SESSION['email'];
$visibility = strtolower($_POST['visibility']);

if (isset($visibility))
{
    $updateUser = "UPDATE FACEBOOKUSER
    SET visibility = :bv_visibility
    WHERE email like :bv_email";

    $stid = oci_parse($conn, $updateUser);

    oci_bind_by_name($stid, ":bv_email", $email);
    oci_bind_by_name($stid, ":bv_visibility", $visibility);
    
    oci_execute($stid);
}
oci_close($conn);
header('Location: ../settings.php');