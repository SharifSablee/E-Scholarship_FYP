<?php 
require_once('db.php');
include('header.php');

if(isset($_POST['changepass'])){
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];
    
    if (empty($password)) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Please enter a password";
        $_SESSION['status_code'] = "error";

    } else if (strlen($password) < 8) {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Password should not be less than 8 characters";
        $_SESSION['status_code'] = "error";

    } else if ($password !== $repeatpassword){
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Password does not match!";
        $_SESSION['status_code'] = "error";

    } else if ((!empty($password)) && (!empty($repeatpassword))){
        $code = 0;
        $id = $_SESSION['id'];
        $email = $_SESSION['email']; //getting this email using session

        $update_pass = "UPDATE user_accounts SET password = sha1('$password') WHERE id = '$id'";
        $run_query = mysqli_query($con, $update_pass);
        
        if($run_query){
            $update_otp = "UPDATE user_otp SET code = $code WHERE user_id = '$id'";
            mysqli_query($con, $update_otp);
            
            $_SESSION['status_title'] = "Success!";
            $_SESSION['status'] = "Password has been changed!";
            $_SESSION['status_code'] = "success";

            header('Location: stud-login.php');
            exit();

        }else{
            $_SESSION['status_title'] = "Error!";
            $_SESSION['status'] = "Fail to change your password!";
            $_SESSION['status_code'] = "error";

        }
    }
}

    ?>

<div class="container container-md container-lg mt-3 px-5">

        <div class="row py-5 mt-4 align-items-center">
            <!-- Logo Image -->
            <div class="col-md-12 col-lg-5 pr-lg-3 mb-5 mb-md-5 text-center">
              
              <!-- <img src="images/E-Scholarship Logo.png" alt="logo" class="img-fluid mb-3 d-none d-md-block img-logo"> -->
                <img src="images/img-01.png" alt="logo" class="myimg">
            </div>

        <!-- new Password Form -->
        <div class="col-md-12 col-lg-6 ml-auto">
        <div class="col-lg-12 mb-4 text-center">
                <h3>New Password</h3>
              </div>
          <form action="" method="post">
            <div class="row">

            <div class="alert alert-success mx-3 myalert">
                <?php echo $_SESSION['info']; ?>
            </div>

              <!-- creating new password -->
              <!-- Password -->
        <div class="input-group col-lg-12 mb-4">
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
        <div class="input-group col-lg-12 mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white px-4 border-md border-right-0">
              <i class="fa fa-lock text-muted"></i>
            </span>
          </div>
          <input class="form-control bg-white border-left-0 border-md"
                  id="repeatpassword"
                  type="password"
                  name="repeatpassword"
                  placeholder="Repeat Password"/>
        </div>

              <!-- send link Button -->
                <div class="form-group col-lg-12 mx-auto mb-4">
                    <input class="btn btn-primary btn-block py-2 font-weight-bold mybutton" type="submit" id="changepass" name="changepass" value="Change Password">
                </div>

            </div>
          </form>
        </div>
      </div>
    
    <?php
    include('script.php');
    ?>