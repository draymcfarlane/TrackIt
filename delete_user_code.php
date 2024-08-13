<?php
include ('dbcon.php');
session_start();

// if the delete button was pressed
if (isset($_POST['delete_user'])) {
   $uid = $_POST['dbdelete']; // assigns the uid for current user
   try {
      $auth->deleteUser($uid); // deletes user data from auth

      $token = $_POST['rtdbdelete']; // retrieves uid for database 
      $ref = "user/users/".$token;

      // deletes from the database   
      $deletedata = $database->getReference($ref)->remove();
      $database->getReference('/user/users/email')->remove();
      header('Location: deleteacc_confirm.php'); // redirects to inform of deletion
   } catch (Exception $e) {
      header("Location: edit_account.php?id=$uid"); // returns with uid in url
   }
}