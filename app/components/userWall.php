<?php session_start(); 
include_once("../../app/vendor/autoload.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://kit.fontawesome.com/356e745068.js"></script>

<!-- jQuery import -->
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
</script>

<link rel="stylesheet" type="text/css" href="../css/app.css">
</head>
<?php
$email = $_SESSION['email'];
// query used to get the post information and user information of the logged in users and their friends
$getPostData = "SELECT p.posterEmail as email, p.bodyText as bodyText, 
fu.screenName as screenName, p.postID, TO_CHAR(p.postTime, 'DD MONTH YYYY HH24:MI')
 as postTime, TO_CHAR(p.postTime, 'YYYYMMDDHH24MISS') as sortField
from POST p
left join FacebookUser fu
on p.posterEmail = fu.email
full outer join Friend f
on fu.email = f.email
where p.originalPostID is null
and p.posterEmail like :bv_email
or friendshipID in 
(
    SELECT friendshipID
    FROM Friend
    WHERE email like :bv_email
    and p.originalPostID is null
)
order by sortfield desc";
$stid = oci_parse($conn, $getPostData);
oci_bind_by_name($stid, ":bv_email", $_SESSION['email']);
oci_execute($stid);
// prints each post one by one until none remain
while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
{
    ?>
    <!-- Each post component as a whole is stored in this div -->
    <div class="post-component">
        <?php
        $noOfLikes = calculateLikes($conn, $row);
        echo '<h3 class="post-screenName">'.$row['SCREENNAME'].'</h3>';
        // component of a single post identified by postID
        echo '<div id="'.$row['POSTID'].'">';
            echo '<div class="post-time">'.$row['POSTTIME'].'</div>';
            echo '<div class="post-body">'.$row['BODYTEXT'].'</div>';
            
        echo '</div>';
        ?>
        <!-- form used to post a like on a post -->
        <form action="functions/postLike.php" method="POST">
            <div class="inline">
                
                <button class="like-button btn-primary" type="submit">Like</button>
                <?php echo '<h3 class="no-of-likes">'.$noOfLikes.'</h3>'?>
                    <!-- carries postid through post request, not displayed on client side -->
                <?php echo '<input class="post-id" name="post-id" type="hidden" value="'.$row['POSTID'].'">';?>
                
            </div>
        </form>
        <div class="inline">
            <!-- form used to leave comment -->
            <form action="functions/leaveComment.php" method="POST">
                <input class="reply-field" name="reply-field" type="text" placeholder="Reply">
                <button class="btn-light" type="submit">
                    <i class="fas fa-reply"></i>
                    <!-- carries postid through post request, not displayed on client side -->
                    <?php echo '<input class="post-id" name="post-id" type="hidden" value="'.$row['POSTID'].'">'; ?>
                </button>
            </form>
        </div>
        <?php
        // grabs and executes query that gets all replies for the post.
        $stidReply = getReplies($conn, $row['POSTID']); 
        ?>
        <div class="reply-component">
        <?php
            while (($rowReply = oci_fetch_array($stidReply, OCI_ASSOC)) != false)
            {
                echo '<h3 class="reply-screenName">'.$rowReply['SCREENNAME'].'</h3>';
                echo '<div class="reply-body-wrapper">'."<p>".$rowReply['BODYTEXT'].'</p></div>';
            }
            ?>
        </div>
    </div>
<?php
}
// calculates number of likes on the each post in the wall
function calculateLikes($conn, $row)
{
    $getLikes ='SELECT COUNT(*) as numberOfLikes
    FROM RATING
    WHERE postID like :bv_postID';
    $stid = oci_parse($conn, $getLikes);
    oci_bind_by_name($stid, ":bv_postID", $row['POSTID']);
    oci_execute($stid);
    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
    {
        return $row['NUMBEROFLIKES'];
    }
}
// retrieves the result of query that gets all replies from a post
function getReplies($conn, $postID)
{
    $getReplies ="SELECT fu.screenName as screenName, p.bodyText as bodyText, TO_CHAR(postTime, 'YYYYMMDDHH24MISS') as sortField
    FROM POST p
    left join FACEBOOKUSER fu
    on p.posterEmail = fu.email
    WHERE p.originalPostID like :bv_postID
    ORDER BY p.postTime DESC";
    $stid = oci_parse($conn, $getReplies);
    oci_bind_by_name($stid, ":bv_postID", $postID);
    oci_execute($stid);
    return $stid;
}
oci_close($conn);
?>