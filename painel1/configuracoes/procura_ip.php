<?php
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  
ob_start();
session_start();

$_SESSION['geolocation'] = $getPost;

