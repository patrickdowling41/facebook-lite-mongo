<!-- Connection setup for MongoDB database -->

<?php
include_once("../../app/vendor/autoload.php");
try {
    $client = new MongoDB\Client("mongodb://mongo:27020");
} 

catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);
}
?>