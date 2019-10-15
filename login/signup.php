<?php require('../db_connect.php');
session_start();
?>
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

// user existence check
$query='SELECT email from FacebookUser';
$stid = oci_parse($conn, $query);
oci_execute($stid);

while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false)
{
    // checks when email exists in the database already
    if (strcmp($row['EMAIL'], $email) == 0)
    {
        // user email already exists, so render the signup page
         include_once('components/nav.php');?>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Sign up to Facebook-Lite</h1>
                    <p class="error">The email provided has an existing account</p>
                    <?php
                    include_once('forms/signup-form.php');
                    $_SESSION['signupSuccess'] = false; ?>
                </div>
            </div>
        </div>
    <?php
    }
}
if (($_SESSION['signupSuccess']))
{
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
    $dateOfBirth=$birthDay.'-'.$month.'-'.$birthYear;

    $query = 'INSERT into FacebookUser 
    (
        email,
        firstName,
        surname,
        screenName,
        dateOfBirth,
        gender,
        visibility,
        passwordHash
    )
    values
    (
        :bv_email,
        :bv_firstName,
        :bv_surname,
        :bv_screenName,
        :bv_dateOfBirth,
        :bv_gender,
        :bv_visibility,
        :bv_passwordHash
    )';

    $screenName= $firstname.' '.$surname;
    $defaultVisibility = "private";

    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":bv_email", $email);
    oci_bind_by_name($stid, ":bv_firstName", $firstname);
    oci_bind_by_name($stid, ":bv_surname", $surname);
    oci_bind_by_name($stid, ":bv_screenName", $screenName);
    oci_bind_by_name($stid, ":bv_dateOfBirth", $dateOfBirth);
    oci_bind_by_name($stid, ":bv_gender", $gender);
    oci_bind_by_name($stid, ":bv_visibility", $defaultVisibility);
    oci_bind_by_name($stid, ":bv_passwordHash", $passwordHash);

    oci_execute($stid);

    // return to login page successfully
    $_SESSION['signupSuccess'] = true;
    header('Location: index.php');
}


?>
