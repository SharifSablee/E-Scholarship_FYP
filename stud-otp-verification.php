<?php
require_once('db.php');
include('header.php');

    $user_id = $_SESSION['id'];

    if(isset($_POST['verifyotp'])) {

      $code = $_POST['otp'];
  
      $check_code = "SELECT * FROM user_otp WHERE user_id = '$user_id'";
      $code_result = mysqli_query($con, $check_code);
  
      if(mysqli_num_rows($code_result) > 0) {
          $fetch_data = mysqli_fetch_assoc($code_result);
          $fetch_otp = $fetch_data['code'];

          if ($code == $fetch_otp) {
            $code = 0;
            $update_otp = "UPDATE user_otp SET code = '$code' WHERE user_id = $user_id";
            $update_result = mysqli_query($con, $update_otp);
            if($update_result) {
                $_SESSION['status_title'] = "Success!";
                $_SESSION['status'] = "OTP Verified!";
                $_SESSION['status_code'] = "success";
    
                header("Location: stud-login.php");
                exit();
            } else {
                $_SESSION['status_title'] = "Error!";
                $_SESSION['status'] = "There is something wrong!";
                $_SESSION['status_code'] = "error";
            }
          } else {
              $_SESSION['status_title'] = "Error!";
              $_SESSION['status'] = "Invalid Code!";
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

        <!-- Forgot Password Form -->
        <div class="col-md-12 col-lg-6 ml-auto">
        <div class="col-lg-12 mb-4 text-center">
                <h3> OTP Verification</h3>
              </div>
          <form action="" method="post">
            <div class="row">

              <!-- OTP code -->
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
                  id="otp"
                  type="number"
                  name="otp"
                  placeholder="OTP Verification Code"
                  class="form-control bg-white border-left-0 border-md"
                  value="<?php if (isset($_POST['otp'])) { echo $_POST['otp'];}?>"

                />
              </div>

              <!-- verify Button -->
              <div class="form-group col-lg-12 mx-auto mb-4">
                  <input class="btn btn-primary btn-block py-1.5 font-weight-bold otp-button" type="submit" id="verifyotp" name="verifyotp" value="Verify">
              </div>

            </div>
          </form>
        </div>
      </div>

  <?php
  include('script.php');
  ?>

    <!-- disable button when mobile number or otp is empty -->
    <script>
      $(document).ready (function () {

        $('input[name="verifyotp"]').attr('disabled', true);
        $('input[name="otp"]').on('keyup', function () {
          var otp = $('#otp').val();
          if (otp != '') {
            $('input[name="verifyotp"]').attr('disabled', false);
          } if (otp.length == 6) {
            $('input[name="verifyotp"]').attr('disabled', false);
          } else {
            $('input[name="verifyotp"]').attr('disabled', true);
          }
        })
      })
    </script>
