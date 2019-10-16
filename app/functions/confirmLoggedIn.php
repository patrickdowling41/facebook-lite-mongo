<?php
// Routes to login page if user is not logged in.
if ($_SESSION['loggedIn'] === 0)
{
    header("Location: ../login");
}
?>