<?php

require('../../db_connect.php');
session_start();

$email = $_SESSION['email'];
$status = $_POST['status'];

if (isset($status))
{
    $updateUser = "UPDATE FACEBOOKUSER
    SET status = :bv_status
    WHERE email like :bv_email";

    $stid = oci_parse($conn, $updateUser);

    oci_bind_by_name($stid, ":bv_email", $email);
    oci_bind_by_name($stid, ":bv_status", $status);
    
    oci_execute($stid);
}
oci_close($conn);
header('Location: ../settings.php');