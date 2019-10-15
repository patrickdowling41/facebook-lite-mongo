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

    <script src="https://kit.fontawesome.com/356e745068.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/app.css">

</head>

<body>

    <nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-10 inline">
                    <a href="index.php"> <i class="home-btn fab fa-facebook-square fa-3x"></i></a>
                    <form action="searchUsers.php" method="POST">
                        <input class="friend-search-field" name="friend-search" type="text" placeholder="Search">
                        <button class="friend-search-btn" type="Submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-xs-2 right-align">
                    <a href="friendRequests.php"> <i class="nav-btn fas fa-user-friends fa-2x"></i></a>
                    <a href="settings.php"> <i class="nav-btn fas fa-cog fa-2x"></i></a>
                    <a href="../login/logout.php"> <i class="nav-btn fas fa-sign-out-alt fa-2x"></i></a>
                </div>
            </div>
        </div>
    </nav>
</body>