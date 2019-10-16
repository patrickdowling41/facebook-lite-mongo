<?php 
require('../../db_connect.php');
session_start();

$postID = $_POST['post-id'];
$email = $_SESSION['email'];

// confirmation check to make sure no one can like multiple times
function alreadyLiked($conn, $postID, $email)
{
    $checkLiked = 'SELECT count(*) as previousLike
    FROM RATING
    WHERE raterEmail like :bv_email
    AND  postID like :bv_postID';
    
    $stid = oci_parse($conn, $checkLiked);
    
    oci_bind_by_name($stid, ":bv_postID", $postID);
    oci_bind_by_name($stid, ":bv_email", $email);
    
    oci_execute($stid);

    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
    {
        return $row['PREVIOUSLIKE'];
    }
    return false;
}

// add like to the table
function addLike($conn, $postID, $email)
{
    $addLike = 'INSERT INTO RATING (
        postID,
        raterEmail
    )
    VALUES
    (
        :bv_postID,
        :bv_email
    )';
    
    $stid = oci_parse($conn, $addLike);
    
    oci_bind_by_name($stid, ":bv_postID", $postID);
    oci_bind_by_name($stid, ":bv_email", $email);
    
    oci_execute($stid);
}

if (alreadyLiked($conn, $postID, $email) == 0)
{
    addLike($conn, $postID, $email);
}
/* you can add an else case if you want to remove the like, however I chose not to for this design */

header('Location: ../index.php');

oci_close($conn);


?>