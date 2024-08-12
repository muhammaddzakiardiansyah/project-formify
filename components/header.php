<?php

session_start();
require './functions.php';

if(isset($_COOKIE["key_1"]) && isset($_COOKIE["key_2"])) {
  $user_id = base64_decode($_COOKIE["key_1"]);
  $user = getUserById($user_id);
  if(!empty($user)) {
    if(hash("sha256", $user["username"]) === $_COOKIE["key_2"]) {
      $_SESSION["user_login"] = ["login" => true, "username" => $user["username"]];
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Web form share question or secret qna">
  <meta name="author" content="M Dzaki Ardiansyah">
  <title><?= $page ?? 'Home' ?> • Codepelita Formify</title>
  <!-- link file bootstrap css -->
  <link rel="stylesheet" href="/<?= $project_name ?>/assets/css/bootstrap.min.css">
  <!-- link file css -->
  <link rel="stylesheet" href="/<?= $project_name ?>/assets/css/style.css">
  <!-- link file favicon -->
  <link rel="shortcut icon" href="/<?= $project_name ?>/assets/images/logo-formify.png" type="image/x-icon">
  <!-- link cdn bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- link file jquery validate js -->
  <script src="/<?= $project_name ?>/assets/js/jquery.min.js"></script>
  <script src="/<?= $project_name ?>/assets/js/jquery.validate.min.js"></script>
  <!-- link file sweet alert js -->
  <script src="/<?= $project_name ?>/assets/js/sweetalert2.all.min.js"></script>
</head>
<body class="b-white">