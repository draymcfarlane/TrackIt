<?php
include("config.php");
include("dbcon.php");
include("firebaseRDB.php");

// if the submit but was clicked
if(isset($_POST['submit'])) {

    // input values
    $email = $_POST ['email'];
    $password = $_POST ['password'];

    // Password strength variables
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    $rdb = new firebaseRDB($databaseURL);

    // error display variables
    $verifyCheck = false;
    $emailRegistered = false;
    $pageRedirect = false;

    // getting data from the database
    $ref_table = 'user/users';
    $fetchdata = $database->getReference($ref_table)->getValue();

    // getting data from authentication
    $users = $auth->listUsers();
        
    foreach($users as $user) { // runs for each user in authentication

        if($fetchdata > 0) { // if data exist in the database

            foreach($fetchdata as $key => $row) { // runs for each row in specified branch in database

                if($row['email'] == $email && $email == $user->email) { // if the email exist
                    $emailRegistered = true;

                    try {
                        // signing in with email and password through database
                        $user = $auth->getUserByEmail($email);
                        $signInResult = $auth->signInWithEmailAndPassword($email, $password);

                        // run another check for the email verification
                        if($fetchdata > 0) { 

                            foreach($fetchdata as $key => $row) {
                                $users = $auth->listUsers(); // resets variable
                                
                                foreach($users as $user) {
                                    if($user->email == $email && $user->emailVerified == true) { // if the email is verified

                                        // directs to passenger page if account was setup as a passenger
                                        if($row['user_type'] == "passenger" && $row['email'] == $email) { 
                                            $_SESSION['user'] = $_POST['email']; // sets the email as a session variable
                                            header("location: user_page.php");

                                        // directs to bus driver page
                                        } elseif ($row['user_type'] == "bus driver" && $row['email'] == $email) { 
                                            $_SESSION['user'] = $_POST['email'];
                                            header("location: admin_page.php");

                                        // if redirection fails
                                        } else{
                                            $pageRedirect = true;
                                        }

                                    }elseif($user->email == $email && $user->emailVerified == false) {  // if the email is not verified
                                        $verifyCheck = true;
                                        break; // breaks out the loop
                                    }
                                }
                            }
                        }
                    } catch (Exception $e) { // if the details are incorrect
                        $error[] = 'Email or Password Incorrect!';
                    }
                }
            }
        }
    }

    if($emailRegistered == false) { // if email doesnt exist
        $error[] = 'Email not registered!';
    }

    if($verifyCheck == true) { // if password conditions are met, creates the user
        $error[] = 'Please verify email before sign in, check the inbox for the verification email.';
    }

    if($pageRedirect == true) { // if page redirection fails
        $error[] = 'Invalid User type set to account, please reach out for assistance.';    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.svg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="form-container">

    <form method="post" action="">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="LOGIN" class="form-btn">
      <p><a href="password_reset.php">forgot password?</a></p>

      <p><a href="resend_verif.php">resend verification?</a></p>

      <p><br><br>don't have an account? <a href="signup.php">register now</a></p>
   </form>

</div>

</body>

</html>