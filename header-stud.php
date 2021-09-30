<?php
session_start();
require_once('db.php');

if (isset($_POST['logout'])) {
  session_start();
  session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap1.min.css" />

    <!-- fontawesome offline library-->
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css" />

    <!-- my custom css file -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- datepicker bootstrap css -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-datepicker3.css"/>    

    <title>E-Scholarship</title>
  </head>

  <body>
    <!-- header of the website -->
    <header>
      <div class="container-fluid">
        <nav
          class="navbar navbar-dark navbar-expand-md"
          style="background-color: #aaa69d"
        >
          <!-- logo -->
          <a href="index.php" class="navbar-brand col-lg-5"
            ><img src="images/logo.png" width="200px" alt="logo"
          /></a>

          <!-- creating the nav menu toggler -->
          <button
            data-toggle="collapse"
            data-target="#navbarToggler"
            type="button"
            class="navbar-toggler"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse col-lg-7" id="navbarToggler">
            <!-- nav menu -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="stud-dashboard.php" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                <a href="stud-profile.php" class="nav-link">Profile</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Quick Links</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Programme Offered</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">FAQ</a>
              </li>
              <li class="nav-item">
                <a href="stud-login.php" class="nav-link">
                  <input type="button" name="logout" id="logout" value="Logout">
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <?php
    include('script.php');
    ?>

</html>
