<?php
include ("dbcon.php");
include ("config.php");
include ("firebaseRDB.php");

// if submit is clicked
if (isset($_POST['submit'])) {

    // assigns input variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    // password strength variables
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    $rdb = new firebaseRDB($databaseURL);

    // error display variables
    $createUser = false;
    $emailRegistered = false;

    $ref_table = 'user/users';
    $fetchdata = $database->getReference($ref_table)->getValue();

    $users = $auth->listUsers();

    foreach ($users as $user) { // check if email already exist
        if ($fetchdata > 0) {
            foreach ($fetchdata as $key => $row) {
                if ($row['email'] == $email && $email == $user->email) {
                    $error[] = 'Email already registered!';
                    $emailRegistered = true;
                }
            }
        }
    }

    if ($emailRegistered == false) { // if email doesnt exist
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $error[] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        } elseif ($password != $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            $createUser = true;
        }
    }

    if ($createUser == true) { // if password conditions are met, creates the user
        $insert = $rdb->insert("/user/users", [ // created in database
            "name" => $name,
            "email" => $email,
            "user_type" => $user_type
        ]);

        $userProperties = [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'displayName' => $name
        ];

        $createdUser = $auth->createUser($userProperties); // created in authentication

        $auth->sendEmailVerificationLink($email); // auto sends verification link to email

        $result = json_decode($insert, 1);
        if (isset($result['name'])) {
            header("location: login_confirm.php"); // redirects to inform user of account creation
        } else {
            $error[] = 'Signup failed, please refresh or revisit the registration page';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- custom css file link  -->
    <link rel="icon" type="image/x-icon" href="images/favicon.svg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <!-- styling for return button -->
    <style>
        #hide1 {
            display: none;
        }

        #back-button {
            border: none;
            background-color: transparent;
            cursor: pointer;
            float: right;
            padding: 0px 10px;
        }

        #back-button:focus {
            outline: none;
        }

        #back-button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">

            <button onclick="goBack()" id="back-button">
                <img src="images/return.png" alt="Go back" style="width: 35px; height: 35px;">
            </button>

            <!-- returns to previous page -->
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

            <h3 class="back_btn">register now</h3>
            <?php
            // displays errors and notifications
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
                ;
            }
            ;
            ?>
            <input type="text" name="name" required placeholder="enter your name">
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" class="input-field" id="password" required placeholder="enter your password">
            <input type="password" name="cpassword" class="input-field" id="cpassword" required placeholder="confirm your password">
            <span class="eye" onclick="doubleHidePassword()">
                <i id="hide1" class="fa fa-eye"></i>
                <i id="hide2" class="fa fa-eye-slash"></i>
            </span>
            <select name="user_type">
                <option value="passenger">passenger</option>
                <option value="bus driver">bus driver</option>
            </select>
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </div>
    <script src="js/hide.js"></script>
</body>

</html>