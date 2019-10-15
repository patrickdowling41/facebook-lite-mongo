<!-- Just destroys session and returns to home page -->
<?php 
session_start();
session_destroy();
header("Location: index.php");
?>