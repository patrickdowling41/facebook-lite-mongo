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

<script src="https://kit.fontawesome.com/356e745068.js"></script>

<link rel="stylesheet" type="text/css" href="../css/app.css">
</head>
<?php

$email = $_SESSION['email'];

// query used to get the post information and user information of the logged in users and their friends
try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;
    $user = $collection->findOne([
        'email' => $email
    ]);

    $userAndFriends = array();

    // adds user themselves to the array
    array_push($userAndFriends, $user->email);

    // adds all the logged in users friends to the array
    foreach($user->friends as $friend)
    {
        array_push($userAndFriends, $friend->email);
    }

    $collection = $client->Assignment2->Post;

    $filler = [
        'posterEmail' => [
            '$in' => $userAndFriends
        ],
        'replyTo' => null,   
    ];
    $options = ['sort' => ['timestamp' => -1]];
    $posts = $collection->find($filler, $options);

    foreach ($posts as $post)
    {
        // get user information for the poster
        $collection = $client->Assignment2->FacebookUser;
        $userInfo = $collection->findOne([
            'email' => $post->posterEmail,
        ]);

        $timestamp = $post->timestamp->toDateTime()->format('F j, Y, g:i a');

        ?>
        <!-- Each post component as a whole is stored in this div -->
        <div class="post-component">
            <?php
            $noOfLikes = sizeOf($post->likes);
            echo '<h3 class="post-screenName">'.$userInfo->screenName.'</h3>';
            // component of a single post identified by postID
            echo '<div id="'.$post->_id.'">';
                echo '<div class="post-time">'.$timestamp.'</div>';
                echo '<div class="post-body">'.$post->body.'</div>';
            echo '</div>';
            ?>
            <!-- form used to post a like on a post -->
            <form action="functions/postLike.php" method="POST">
                <div class="inline">
                    <button class="like-button btn-primary" type="submit">Like</button>
                    <?php echo '<h3 class="no-of-likes">'.$noOfLikes.'</h3>'?>
                        <!-- carries postid through post request, not displayed on client side -->
                    <?php echo '<input class="post-id" name="post-id" type="hidden" value="'.$post->_id.'">';?>
                </div>
            </form>
            <?php
            // grabs and executes query that gets all replies for the post.
            $replies = getReplies($post->_id); 
            ?>
            <div class="reply-component">
                <?php

                $fbUserCollection = $client->Assignment2->FacebookUser;
                $postCollection = $client->Assignment2->Post;

                ?>
                <div class="inline">
                    <!-- form used to leave comment -->
                    <form action="functions/leaveComment.php" method="POST">
                        <input class="reply-field" name="reply-field" type="text" placeholder="Reply to post">
                        <button class="btn-light" type="submit">
                            <i class="fas fa-reply"></i>
                            <!-- carries postid through post request, not displayed on client side -->
                            <?php echo '<input class="post-id" name="post-id" type="hidden" value="'.$reply->_id.'">'; ?>
                        </button>
                    </form>
                </div>
                <?php

                foreach($replies as $reply)
                {
                    renderReply($fbUserCollection, $postCollection, $reply);   
                }
                ?>
                </div>
            </div>
        <?php
    }
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}

// retrieves the result of query that gets all replies from a post
function getReplies($postID)
{
    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");

        $collection = $client->Assignment2->Post;
        $replies = $collection->find(['replyTo'=> $postID]);

        return $replies;
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }
}
function renderReply($fbUserCollection, $postCollection, $reply)
{
    if(isset($reply->posterEmail) === true)
    {
        // get the user information for each reply
        $userInfo = $fbUserCollection->findOne([
            'email' => $reply->posterEmail
        ]);
        $previousPost = $postCollection->findOne([
            '_id' => $reply->replyTo,
        ]);
        $originalSenderInfo = $fbUserCollection->findOne([
            'email' => $previousPost->posterEmail
        ]);
        echo '<h3 class="reply-screenName">'.$userInfo->screenName. ' replying to: '. $originalSenderInfo->screenName. '</h3>';
        echo '<div class="reply-body-wrapper">'."<p>".$reply->body.'</p></div>';

        ?>
        <div class="inline">
            <!-- form used to leave comment -->
            <form action="functions/leaveComment.php" method="POST">
                <input class="reply-field" name="reply-field" type="text" placeholder="Reply to comment">
                <button class="btn-light" type="submit">
                    <i class="fas fa-reply"></i>
                    <!-- carries postid through post request, not displayed on client side -->
                    <?php echo '<input class="post-id" name="post-id" type="hidden" value="'.$reply->_id.'">'; ?>
                </button>
            </form>
        </div>

        <?php
        $nestedReplies = getReplies($reply->_id); 
        foreach($nestedReplies as $nestedReply)
        {
            echo '<div class="indent">';
                renderReply($fbUserCollection, $postCollection, $nestedReply);
            echo '</div>';
        }
    }
}
?>