<?php
require_once('db.php');
include('header.php');

// to sent email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['sendlink'])){
  $email = $_POST['email'];
  $check_email = "SELECT * FROM user_accounts WHERE email='$email'";
  $run_sql = mysqli_query($con, $check_email);

  if(mysqli_num_rows($run_sql) > 0){
      $fetch_data = mysqli_fetch_assoc($run_sql);
      $user_id = $fetch_data['id'];
      $name = $fetch_data['name'];
      $_SESSION['id'] = $user_id;

      $code = rand(999999, 111111);
      $insert_code = "UPDATE user_otp SET code = $code WHERE user_id = '$user_id'";
      $run_query =  mysqli_query($con, $insert_code);
      if($run_query){
        $mail = new PHPMailer();
        $mail->IsSMTP();
      
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "escholarship.bn@gmail.com";
        $mail->Password   = "escholarship.2021";
      
        $mail->IsHTML(true);
        $mail->AddAddress($email, $name);
        $mail->SetFrom("escholarship.bn@gmail.com", "E-Scholarship");
        $mail->AddReplyTo("escholarship.bn@gmail.com", "E-Scholarship");
        // $mail->AddCC("cc-recipient-email", "cc-recipient-name");
        $mail->Subject = "Reset Password - Code Verification";
        $content = "Hi " . $name . ", <br><br>We received request to reset the password for your account.
        <br><br>Your Verification Code is:<br>" . $code;
      
        $mail->MsgHTML($content); 
        if(!$mail->Send()) {
          echo "Error while sending Email.";
      
          $_SESSION['status_title'] = "Error!";
          $_SESSION['status'] = "Failed to send the email!";
          $_SESSION['status_code'] = "error";
      
          var_dump($mail);
        } else {
          echo "Email sent successfully";
      
          $_SESSION['email'] = $email;
      
          $_SESSION['status_title'] = "Success!";
          $_SESSION['status'] = "Password has been sent to your email";
          $_SESSION['status_code'] = "success";
      
          header('location: stud-reset-password.php');
          exit();
        }
      }else{
          echo "something went wrong";
      }
  }else{
    $_SESSION['status_title'] = "Error!";
    $_SESSION['status'] = "Account does not exist!";
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
                <h3> Forgot Password</h3>
              </div>
          <form action="" method="post">
            <div class="row">

              <!-- Email Address -->
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
                    <i class="fa fa-envelope text-muted"></i>
                  </span>
                </div>
                <input
                  id="email"
                  type="email"
                  name="email"
                  placeholder="Email Address"
                  class="form-control bg-white border-left-0 border-md"
                  value="<?php if (isset($_POST['email'])) { echo $_POST['email'];}?>"

                />
              </div>

              <!-- send link Button -->
                <div class="form-group col-lg-12 mx-auto mb-4">
                    <input class="btn btn-primary btn-block py-2 font-weight-bold mybutton" type="submit" id="sendlink" name="sendlink" value="Send Link">
                </div>

            </div>
          </form>
        </div>
      </div>
    
    <?php
    include('script.php');
    ?>