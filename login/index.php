<?php session_start();

// moves user directly to app if logged in already
    if ($_SESSION["loggedIn"] === 1)
    {
        header("Location: ../app");
    }
?>

<head>   

    <title>Facebook | Log in or Sign up</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 

    <!-- Facebook logo font -->
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/login.css">

</head>
<body>

<?php include_once('components/nav.php');?>

<div class="container">
    <div class="row page-content">
        <!-- Left hand column for Recent Login -->
        <div class="span-page col-lg-6">
            <h2>Facebook helps you connect and share with the people in your life.</h2>
            <img id="login-map" src="../img/login-map.png">
        </div>

        <!-- Right hand column for Account Registration -->
        <div class="col-lg-6">
            <h1>Create a new account</h1>
            <h3>It's quick and easy</h3>

            <!-- renders signup form from external module -->
            <?php include_once("components/signup-form.php");?>
        </div>
    </div>
</div>

</body>

</html>