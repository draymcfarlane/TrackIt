<?php

@include 'config.php';

session_start();

// unsets any session variables
session_unset();
session_destroy();

header('location:login.php'); // redirects to login
