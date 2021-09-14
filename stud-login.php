<?php
require('db.php');
require('header.php');

    if(isset($_POST['login'])) {
		//something was posted
		$email = $_POST['email'];
		$password = sha1($_POST['password']);

        // validating the input
		if(!empty($email) && 
            !empty($password)) {

			$query = "SELECT * FROM user_accounts WHERE email = '$email' limit 1";
			$result = mysqli_query($con, $query);

            if($result) {
                if($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password'] === $password) {
                        $_SESSION['id'] = $user_data['id'];
                        $_SESSION['name'] = $user_data['name'];
                        $_SESSION['email'] = $user_data['email'];
                        $_SESSION['phone_number'] = $user_data['phonenumber'];
                        $_SESSION['password'] = $user_data['password'];
                        $role = $user_data['user_role'];

                        $user_id = $_SESSION['id'];

                        // if ($role == "admin") {
                        //   header("Location: admin-dashboard.php");
                        //   die;

                        // } else if ($role == "student") {
                          $check = "SELECT * FROM stud_profiles WHERE user_id = $user_id";
                          $run_check = mysqli_query($con, $check);
                          
                          if ($run_check) {
                            if ($run_check && mysqli_num_rows($run_check) > 0) {
                                  header("Location: stud-dashboard.php");
                                  die;
                    
                            } else {
                                $profile = "INSERT INTO stud_profiles (user_id) VALUES ($user_id)";
                                $run_profile = mysqli_query($con, $profile);
                                if ($run_profile) {
                                  header("Location: stud-dashboard.php");
                                  die;
                                } else {
                                  $_SESSION['status_title'] = "Error";
                                  $_SESSION['status'] = "Something went wrong";
                                  $_SESSION['status_code'] = "error";
                                }
                            }
                          }
                        // } else if ($role == "agency") {
                        //   header("Location: agency-dashboard.php");
                        //   die;

                        // }

                    } else {
                        $_SESSION['status_title'] = "Error!";
                        $_SESSION['status'] = "Wrong Credentials!";
                        $_SESSION['status_code'] = "error";
                    }
                }
            }
    } else if(
      empty($email) || 
      empty($password) ||
      (empty($email) && empty($password)))
      {

      $_SESSION['status_title'] = "Opps...";
      $_SESSION['status'] = "You forgot to fill in something";
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

        <!-- Login Form -->
        <div class="col-md-12 col-lg-6 ml-auto">
        <div class="col-lg-12 mb-4 text-center">
                <h3> Login</h3>
              </div>
          <form action="" method="post" autocomplete="off">
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
                  type="text"
                  name="email"
                  placeholder="Email Address"
                  class="form-control bg-white border-left-0 border-md"
                  value="<?php if (isset($_POST['email'])) { echo $_POST['email'];}?>"

                />
              </div>

              <!-- Password -->
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
                    <i class="fa fa-lock text-muted"></i>
                  </span>
                </div>
                <input
                  id="password"
                  type="password"
                  name="password"
                  placeholder="Password"
                  class="form-control bg-white border-left-0 border-right-0 border-md"
                  
                />
                <div class="input-group-prepend">
                <span toggle="#password" class="input-group-text pt-2
                bg-white border-left-0 border-md fa fa-eye field-icon toggle-password"></span>
                </div>

                
              </div>

              <!-- Login Button -->
              <div class="form-group col-lg-12 mx-auto mb-4">
                  <input class="btn btn-primary btn-block py-2 font-weight-bold mybutton" type="submit" id="login" name="login" value="Login">
              </div>

              <!-- Forgot Password -->
              <div class="text-center w-100">
                <p class="text-muted font-italics">
                  <a href="stud-forgot-password.php" class="text-primary ml-2 mylink">Forgot Password?</a>
                </p>
              </div>

              <!-- Register -->
              <div class="text-center w-100">
                <p class="text-muted font-weight-bold">
                  Not yet registered?
                  <a href="stud-register.php" class="text-primary ml-2 mylink">Create Account</a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    
    <?php
    include('script.php');
    ?>