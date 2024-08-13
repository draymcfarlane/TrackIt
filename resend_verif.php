<?php
include ("config.php");
include ("dbcon.php");
include ("firebaseRDB.php");

// if the submit but was clicked
if (isset($_POST['resendemail'])) {

  // input values
  $email = $_POST['email'];

  // error display variables
  $emailRegistered = false;

  // getting data from the database
  $ref_table = 'user/users';
  $fetchdata = $database->getReference($ref_table)->getValue();

  // getting data from authentication
  $users = $auth->listUsers();

  foreach ($users as $user) { // check if email already exist
    if ($fetchdata > 0) {
      foreach ($fetchdata as $key => $row) {
        if ($row['email'] == $email && $email == $user->email) {
          $emailRegistered = true;
        }
      }
    }
  }

  if ($emailRegistered == false) { // if email doesnt exist
    $error[] = 'Email not registered!';
  } else {
    // resends link and redirects to login page
    $auth->sendEmailVerificationLink($email);
    header("location: login.php");
  }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verification Email Resend</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.svg">
  <link rel="stylesheet" href="css/style.css">

  <!-- styling for return button -->
  <style>
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
    <form method="post" action="">

      <button onclick="goBack()" id="back-button">
        <img src="images/return.png" alt="Go back" style="width: 35px; height: 35px;">
      </button>

      <!-- returns to previous page -->
      <script>
        function goBack() {
          window.history.back();
        }
      </script>

      <h3>Enter unverified email to receive verification link</h3>

      <?php
      // displays all error codes
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<span class="error-msg">' . $error . '</span>';
        }
        ;
      }
      ;
      ?>

      <input type="email" name="email" required placeholder="enter your email">
      <input type="submit" onclick="document.getElementById('id01').style.display='block'" name="resendemail"
        value="submit" class="form-btn">

      <div id="id01" class="modal ">
        <form method="post" action="">
          <div class="mdcontainer">
            <h1>Sending link!</h1>
            <p>One moment please...</p>
          </div>
        </form>
      </div>
    </form>
  </div>
</body>

</html>