<?php
require_once('db.php');
include('header.php');
require('autoload.php');

if(isset($_POST['register'])) {

    //something was posted
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    if (empty($name) &&
    empty($email) &&
    empty($phonenumber) &&
    empty($password) &&
    empty($repeatPassword)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Fields are empty!";
        $_SESSION['status_code'] = "error";

    } else if (empty($name)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Name is empty";
        $_SESSION['status_code'] = "error";

    } else if (empty($email)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Email is empty";
        $_SESSION['status_code'] = "error";

    } else if (empty($phonenumber)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Phone Number is empty";
        $_SESSION['status_code'] = "error";

    } else if (strlen($phonenumber) < 6) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Please enter a valid phone number";
        $_SESSION['status_code'] = "error";

    } else if (empty($password)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Password is empty";
        $_SESSION['status_code'] = "error";

    } else if (strlen($password) < 8) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Password should not be less than 8 characters";
        $_SESSION['status_code'] = "error";

    } else if ($repeatPassword != $password) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Password does not match";
        $_SESSION['status_code'] = "error";

    } else if (
        !empty($name) && 
        !empty($email) && 
        !empty($phonenumber) && 
        !empty($password) &&
        !empty($repeatPassword) &&
        $repeatPassword == $password) {

        //check for email duplicate
        $email_check = "SELECT * FROM user_accounts WHERE email = '$email'";
        $res = mysqli_query($con, $email_check);

        if (mysqli_num_rows($res) > 0) {
            $_SESSION['status_title'] = "Error!";
            $_SESSION['status'] = "Email has already associated with an existing account";
            $_SESSION['status_code'] = "error";
        } else {
            $query = "INSERT INTO user_accounts (name, email, phone_number, password, user_role) VALUES ('$name', '$email', '$phonenumber', sha1('$password'), 'student')";
            $run_query = mysqli_query($con, $query);

            if ($run_query) {
              $select = "SELECT * FROM user_accounts WHERE email = '$email' limit 1";
              $run_select = mysqli_query($con, $select);

              if ($run_select) {
                if ($run_select && mysqli_num_rows($run_select) > 0) {
                  $fetch_data = mysqli_fetch_assoc($run_select);
                  $_SESSION['id'] = $fetch_data['id'];
                  $user_id = $_SESSION['id'];

                  // send otp
                  // live api
                  // $messagebird = new MessageBird\Client('m71wgmhmdo7oEcmwYPouFrQfc');
                  // test api
                  $messagebird = new MessageBird\Client('Er1avKftOOtJQq9CmxsPlqEEo');
                  $message = new MessageBird\Objects\Message;
                  $message->originator = '+6738391204';
                  $message->recipients = [ '+6738391204' ];
                  $otp = mt_rand(100000, 999999);
                  $message->body = "Hello " . $name . ". Your E-Scholarship code is " . $otp;
                  $response = $messagebird->messages->create($message);

                  $save_otp = "INSERT INTO user_otp (user_id, code) VALUES ('$user_id', '$otp')";
                  mysqli_query($con, $save_otp);
                }
              }
            }

            header("Location: stud-otp-verification.php");
            die;
        }
    }
}
?>

<div class="container" >
  <div class="row py-5 mt-4 align-items-center">
      <!-- For Demo Purpose -->
      <div class="col-md-12 col-lg-5 pr-lg-5 mb-5 mb-md-5 text-center">
          <h2 class="h2-reg"><img src="images/E-Scholarship.png" alt="logo" width="150px" style="padding-bottom: 20px;">
          <br>E-Scholarship Sign Up!</h2>
          <p class="font-italic text-muted mb-0 p-reg">Create your account. It's free and it will only take a minute.</p>
          <p class="font-italic text-muted p-reg">Your profile will be included in each application you submit, 
            so you'll always look great to scholarship panels.</p>

      </div>

  <!-- Registration Form -->
  <div class="col-md-12 col-lg-7 col-lg-6 ml-auto">
    <form action="" method="post" autocomplete="off">
      <div class="row">
        <!-- First Name -->
        <div class="input-group col-lg-12 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-user text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-left-0 border-md" 
                  id="name" 
                  type="text" 
                  name="name" 
                  placeholder="Name" 
                  value="<?php if (isset($_POST['name'])) { echo $_POST['name'];}?>">
        </div>

        <!-- Email Address -->
        <div class="input-group col-lg-12 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-envelope text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-left-0 border-md"
                  id="email"
                  type="email"
                  name="email"
                  placeholder="Email Address"
                  value="<?php if (isset($_POST['email'])) { echo $_POST['email'];}?>">
        </div>

        <!-- Phone Number -->
        <div class="input-group col-lg-12 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-phone-square text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-md border-left-0 pl-3"
                  id="phonenumber"
                  type="tel"
                  name="phonenumber"
                  placeholder="Phone Number"
                  value="<?php if (isset($_POST['phonenumber'])) { echo $_POST['phonenumber'];}?>"/>
        </div>

        <!-- Password -->
        <div class="input-group col-lg-6 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-lock text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-left-0 border-right-0 border-md"
                  id="password"
                  type="password"
                  name="password"
                  placeholder="Password"
                  value="<?php if (isset($_POST['password'])) { echo $_POST['password'];}?>"/>
          <div class="input-group-prepend">
          <span toggle="#password" class="input-group-text pt-2
          bg-white border-left-0 border-md fa fa-eye field-icon toggle-password"></span>
          </div>
        </div>

        <!-- Password Confirmation -->
        <div class="input-group col-lg-6 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-lock text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-left-0 border-md"
                  id="repeatPassword"
                  type="password"
                  name="repeatPassword"
                  placeholder="Repeat Password"/>
        </div>

        <!-- Submit Button -->
        <div class="form-group col-lg-12 mx-auto mb-0">
            <input class="btn btn-primary btn-block py-2 font-weight-bold mybutton" type="submit" id="register" name="register" value="Create your account">
        </div>

        <!-- Divider Text -->
        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
          <div class="border-bottom w-100 ml-5 mydivider"></div>
          <span class="px-2 small text-muted font-weight-bold text-muted">
            OR
          </span>
          <div class="border-bottom w-100 mr-5 mydivider"></div>
        </div>

        <!-- Already Registered -->
        <div class="text-center w-100">
          <p class="text-muted font-weight-bold ">
            Already Registered?
            <a href="stud-login.php" class="text-primary ml-2 mylink">Login</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
include('script.php');
?>
