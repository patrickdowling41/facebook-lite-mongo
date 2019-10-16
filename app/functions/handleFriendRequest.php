<?php
require('../../db_connect.php');
session_start();
$senderEmail = $_POST['friend-email'];
$friendEmail = $_SESSION['email'];
$requestID = $_POST['friend-requestID'];
// when friendship is accepted, create the friendship
if (strcmp($_POST['task'], 'accept') == 0)
{
    addFriend($conn, $senderEmail, $friendEmail);
} 
// request is deleted regardless of whether the friendship is accepted or declined.
deleteRequest($conn, $requestID);
function addFriend($conn, $senderEmail, $friendEmail)
{
    // create the Friend Request entity
    $startDate = date('d-M-y');
    $createFriendship ="INSERT INTO FRIENDSHIP
    (
        startDate,
        friendType
    )
    values
    (
        :bv_startDate,
        'friend'
    )";
    $stid = oci_parse($conn, $createFriendship);
    oci_bind_by_name($stid, ':bv_startDate', $startDate);
    oci_execute($stid);
    // retried request ID for the newly created friendship
    $retrieveID = 'SELECT friendshipid_seq.currval as ID from dual';
    $stid = oci_parse($conn, $retrieveID);
    oci_execute($stid); 
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $friendshipID = $row['ID'];
    // add sender to the friendship
    createFriendEntity($conn, $friendshipID, $senderEmail);
    // add receiver to the friendship
    createFriendEntity($conn, $friendshipID, $friendEmail);
    
}
// each user has a friend entity for each friendship to join the two users on friendshipID
function createFriendEntity($conn, $friendshipID, $userEmail)
{
    $createFriendEntity = 'INSERT INTO FRIEND
    (
        email,
        friendshipID
    )
    values
    (
        :bv_email,
        :bv_friendshipID
    )';
    $stid = oci_parse($conn, $createFriendEntity);
    oci_bind_by_name($stid, ':bv_friendshipID', $friendshipID);
    oci_bind_by_name($stid, ':bv_email', $userEmail);
    oci_execute($stid);
}
function deleteRequest($conn, $requestID)
{
    // delete from friendrequest table
    $deleteFromFriendRequest = 'DELETE
    FROM FRIENDREQUEST
    WHERE requestID like :bv_requestID';
    $stid = oci_parse($conn, $deleteFromFriendRequest);
    oci_bind_by_name($stid, ':bv_requestID', $requestID);
    oci_execute($stid);
    // delete from userrequest table
    $deleteFromUserRequest = 'DELETE
    FROM USERREQUEST
    WHERE requestID like :bv_requestID';
    $stid = oci_parse($conn, $deleteFromUserRequest);
    oci_bind_by_name($stid, ':bv_requestID', $requestID);
    oci_execute($stid);
}
header('Location: ../friendRequests.php');
oci_close($conn);