<head>    
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

<!-- Nav bar -->
<nav class="login-nav">
    <div class="container">
        <div class="row nav-content">

            <!-- column for logo -->
            <div class="col-sm-6 fb-nav-logo">
                <i height="62" width="170">Facebook-Lite</i>
            </div>
            <!-- column for login -->
            <div class="col-lg-6">
                
                <form name="login-form" action="login.php" method="POST">

                    <!-- another row nested within the previous row for the login -->
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="login-tag">Email</div>
                                <input class="login-field" type="text" name="login-email">
                            </div>
                            <div class="col-sm-2">
                                <div class="login-tag">Password</div>
                                <input class="login-field" type="password" name="login-password">
                            </div> 
                            <div class="col-sm-2">
                                <button type="submit" class="login-btn btn-primary">Log in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>