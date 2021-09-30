<?php 
require_once('db.php');
include('header.php'); ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: stud-login.php');
}

if(isset($_POST['verifycode'])){
        $_SESSION['info'] = "";
        $code = $_POST['resetcode'];
        $check_code = "SELECT * FROM user_otp WHERE code = $code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: stud-new-password.php');
            exit();
        }else{
            $_SESSION['status_title'] = "Error!";
            $_SESSION['status'] = "Invalid Code!";
            $_SESSION['status_code'] = "error";
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

        <!-- Forgot Password Form -->
        <div class="col-md-12 col-lg-6 ml-auto">
        <div class="col-lg-12 mb-4 text-center">
                <h3>Reset Password</h3>
              </div>
          <form action="" method="post">
            <div class="row">

              <!-- reset password code -->
              <div class="input-group col-lg-12 mb-4">
                <div class="input-group-prepend">
                  <span
                    class="
                      input-group-text
                      bg-white
                      px-4
                      border-md border-right-0
                    "
                  >
                    <i class="fa fa-key text-muted"></i>
                  </span>
                </div>
                <input
                  id="resetcode"
                  type="number"
                  name="resetcode"
                  placeholder="Enter Code"
                  class="form-control bg-white border-left-0 border-md"
                  value="<?php if (isset($_POST['resetcode'])) { echo $_POST['resetcode'];}?>"

                />
              </div>

              <!-- send link Button -->
                <div class="form-group col-lg-12 mx-auto mb-4">
                    <input class="btn btn-primary btn-block py-2 font-weight-bold mybutton" type="submit" id="verifycode" name="verifycode" value="Verify Code">
                </div>

            </div>
          </form>
        </div>
      </div>
    
    <?php
    include('script.php');
    ?>

<script>
  $("verifycode").click(function() {
      $(this).toggleClass(".myalert");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
      input.attr("type", "text");
      } else {
      input.attr("type", "password");
      }
  });
</script>