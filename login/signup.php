<?php session_start();
include_once("../../app/vendor/autoload.php"); ?>
<title>Facebook | Log in or Sign up</title>
    
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='shortcut icon' type='image/svg' href='../img/favicon.svg' />

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

<?php
// assume signup is successful until it fails.
$_SESSION['signupSuccess'] = true;
$firstname = $_POST['firstname'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$passwordHash = hash("sha256", $_POST['password']);
$birthDay = $_POST['day'];
$birthMonth = $_POST['month'];
$birthYear = $_POST['year'];

try
{
    $client = new MongoDB\Client("mongodb://mongo:27017");

    $collection = $client->Assignment2->FacebookUser;
    $result = $collection->find(array(
        'email' => $email,
    ));

    // will only enter loop if the email already exists
    foreach($result as $document)
    {  
        include_once('components/nav.php');?>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Sign up to Facebook-Lite</h1>
                    <p class="error">The email provided has an existing account</p>
                    <?php
                    include_once('components/signup-form.php');
                    $_SESSION['signupSuccess'] = false; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
}


if (($_SESSION['signupSuccess']))
{
    $_SESSION['signupEmail'] = $email;
    if (!isset($_POST['gender']))
    {
        $gender = NULL;
    }
    else
    {
        $gender = $_POST['gender'];
    }
    // Changes number of month to accepted oracle month
    switch ($birthMonth)
    {
        case 1:
            $month='JAN';
            break;
        case 2:
            $month='FEB';
            break;
        case 3:
            $month='MAR';
            break;
        case 4:
            $month='APR';
            break;
        case 5:
            $month='MAY';
            break;
        case 6:
            $month='JUN';
            break;
        case 7:
            $month='JUL';
            break;
        case 8:
            $month='AUG';
            break;
        case 9:
            $month='SEP';
            break;
        case 10:
            $month='OCT';
            break;
        case 11:
            $month='NOV';
            break;
        case 12:
            $month='DEC';
            break;
    }
    $dateOfBirth=$month.' '.$birthDay.', '.$birthYear;

    try
    {
        $client = new MongoDB\Client("mongodb://mongo:27017");

        $collection = $client->Assignment2->FacebookUser;
        $insertOneResult = $collection->insertOne([
            'email' => $email,
            'passwordHash' => $passwordHash,
            'firstName' => $firstname,
            'surname' => $surname,
            'dateOfBirth' => Date($dateOfBirth),
            'gender' => $gender,
            'visibility' => 'Private'
        ]);
    }
    catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
    }

}
?>

<script>
    window.onload = () => { 
        window.location.replace("additionalDetails.php");
    }
</script>