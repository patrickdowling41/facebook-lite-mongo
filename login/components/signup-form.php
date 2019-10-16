<!DOCTYPE html>
<html lang="en">
<head>

<form name="signup-form" action="signup.php" method="POST">

    <!-- Full Name --> 
    <div class="inline">
        <input class="signup-field" type="text" name="firstname" placeholder="First name" required />
        <input class="signup-field" type="text" name="surname" placeholder="Surname" required />
    </div><br>
    <!-- End full name segment -->

    <input class="signup-field" type="text" name="email" placeholder="Email" required /><br>
    <input class="signup-field" type="password" name="password" placeholder="New password" required /><br>
    
    <div class="title-tag">Birthday</div>
    <div class="inline">

    <!-- Select for Day of birthday -->
    <select class="login-dropdown" name="day" required>
        <option value="Day" selected disabled >Day</option>
        <?php
            for ($day = 1; $day<= 31; $day++)
            {
                echo '<option value="'.$day.'">'.$day.'</option>';
            }
        ?>
    </select>

    <!-- Select for Month of birthday -->
    <select class="login-dropdown" name="month">
        <option value="Month" selected disabled required >Month</option>
        <?php
            for ($month = 1; $month<= 12; $month++)
            {
                echo '<option value="'.$month.'">'.$month.'</option>';
            }
        ?>
    </select>
    <!-- Select for Year of birthday -->
    <select class="login-dropdown"  name="year">
        <option value="Year" selected disabled>Year</option>
        <?php
            $currentYear = date('Y');
            for ($year = $currentYear; $year >= $currentYear - 80; $year--)
            {
                echo '<option value="'.$year.'">'.$year.'</option>';
            }
        ?>
    </select>
    </div>
    <div class="title-tag">Gender</div>

    <!-- Gender options radio buttons -->
    <label class="radio-inline">
        <input class="gender" type="radio" name="gender" value="male"> Male<br>
    </label>
    <label class="radio-inline">
        <input class="gender" type="radio" name="gender" value="female"> Female<br>
    </label>
    <label class="radio-inline">
        <input class="gender" type="radio" name="gender" value="other"> Other<br>
    </label>
    </div><br>
    <button class="sign-up-btn btn btn-success" type="submit">Sign Up</button>

</form> 