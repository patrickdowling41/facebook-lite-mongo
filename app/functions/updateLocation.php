<?php
require('../../db_connect.php');
session_start();
$email = $_SESSION['email'];
$city = $_POST['location-city'];
$country = $_POST['location-country'];
$locationID = null;
// double check server side they're set.
if (isset($city) && isset($country))
{
    // will need to create a new location if it's not already in the location table, so this checks for existing location
    $checkLocationExistence = 'SELECT locationID
    FROM LOCATION
    WHERE city like :bv_city
    AND country like :bv_country';
    $stid = oci_parse($conn, $checkLocationExistence);
    oci_bind_by_name($stid, ":bv_city", $city);
    oci_bind_by_name($stid, ":bv_country", $country);
    oci_execute($stid);
    
    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
    {
        $locationID = $row['LOCATIONID'];
    }
    // locationID will only be set if there is a row in the previous while loop
    if (isset($locationID) == false)
    {
        // create new location
        insertLocation($conn, $country, $city);
        $locationID = retrieveLocation($conn, $country, $city);
    }
    // update the user with the new location
    updateUser($conn, $locationID, $email);
    
}
function insertLocation($conn, $country, $city)
{
    $insertLocation = 'INSERT INTO LOCATION
    (
        city,
        country
    )
    values
    (
        :bv_city,
        :bv_country
    )';
    $stid = oci_parse($conn, $insertLocation);
    oci_bind_by_name($stid, ":bv_city", $city);
    oci_bind_by_name($stid, ":bv_country", $country);
    oci_execute($stid);
}
function retrieveLocation($conn, $city, $country)
{
    $retrieveLocation = 'SELECT location_seq.currval as ID from dual';
    $stid = oci_parse($conn, $retrieveLocation);
    oci_execute($stid);
    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
    {
        return $row['ID'];
    }
}
function updateUser($conn, $locationID, $email)
{
    $updateUser = "UPDATE FACEBOOKUSER
    SET locationID = :bv_locationID
    WHERE email like :bv_email";
    $stid = oci_parse($conn, $updateUser);
    oci_bind_by_name($stid, ":bv_email", $email);
    oci_bind_by_name($stid, ":bv_locationID", $locationID);
    
    oci_execute($stid);
}
oci_close($conn);
header('Location: ../settings.php');
?>