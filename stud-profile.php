<?php
require 'db.php';
include 'header-stud.php';
include 'stud-save-profile.php';

$id = $_SESSION['id'];
$data     = "SELECT * FROM user_accounts WHERE id = $id";
$run_data = mysqli_query($con, $data);
if ($run_data) {

    $fetch_info  = mysqli_fetch_assoc($run_data);
    $name        = $fetch_info['name'];
    $email       = $fetch_info['email'];
    $phonenumber = $fetch_info['phone_number'];
}

// save the changes made 
if (isset($_POST['save-myprofile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    
    if (!empty($name) &&
    !empty($email) &&
    !empty($phonenumber)) {

        $update = "UPDATE user_accounts SET name = '$name', email = '$email', phone_number = '$phonenumber' WHERE id = $id";
        $run_update = mysqli_query($con, $update);
    
        if ($run_update) {
            $_SESSION['status_title'] = "Success!";
            $_SESSION['status'] = "Your profile has been updated!";
            $_SESSION['status_code'] = "success";

            header("Location: stud-profile.php");
        } else {
            $_SESSION['status_title'] = "Opps...";
            $_SESSION['status'] = "Your profile is not updated";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Please do not leave anything empty";
        $_SESSION['status_code'] = "error";
    }
}

// to display progress
$query = "SELECT name, email, phone_number
          FROM user_accounts
          WHERE id=$id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
   $user = mysqli_fetch_assoc($result);
   $maximumPoints = 100;
   $user_points = 0;

   if ($user['name'] != "") {
      $user_points = $user_points + 33;
   } else {
      $user_points = $user_points;
   }

   if ($user['email'] != "") {
      $user_points = $user_points + 33;
   } else {
      $user_points = $user_points;
   }

   if ($user['phone_number'] != 0) {
      $user_points = $user_points + 33;
   } else {
      $user_points = $user_points;
   }

   if ($user['name'] != "" && $user['email'] != "" && $user['phone_number'] != 0) {
      $user_points = 100;
   } else {
      $user_points = $user_points;
   }
}

?>

<div class="container bootstrap snippet pt-4">
    <div class="row">
        <div class="container mb-3">
            <h1>Profile</h1>
        </div>
    </div>
    <div class="row">
        <!--left col-->
        <div class="col-sm-3">
            <!-- profile image -->
            <?php
                $profile     = "SELECT * FROM stud_profiles WHERE user_id = $id";
                $run_profile = mysqli_query($con, $profile);
                if (mysqli_num_rows($run_profile) > 0) {
                    $fetch_pict = mysqli_fetch_assoc($run_profile);
                    if ($fetch_pict['profile_picture'] == "") {
                        echo "
                            <form action='stud-profile.php' method='post' enctype='multipart/form-data'>
                                <div class='form-group text-center'>
                                    <img src='images/placeholder.png' onclick='triggerClick()' id='profileDisplay'>
                                    <input type='file' name='profileImage' onchange='displayImage(this)' id='profileImage' style='display: none;'>
                                    <input type='submit' id='save-pict' name='save-pict' class='btn btn-primary mt-3 d-none' value='Save' />
                                </div>
                            </form>
                        ";
                    } else {
                        echo "
                            <form action='stud-profile.php' method='post' enctype='multipart/form-data'>
                                <div class='form-group text-center'>
                                    <img src='uploads/profile_" . $id . ".jpg' onclick='triggerClick()' id='profileDisplay' alt='Profile Picture'>
                                    <input type='file' name='profileImage' onchange='displayImage(this)' id='profileImage' style='display: none;'>
                                    <input type='submit' id='save-pict' name='save-pict' class='btn btn-primary mt-3 d-none' value='Save' />
                                </div>
                            </form>
                        ";
                    }
                }
            ?>

            <div class="list-group ml-3">
                <a href="stud-profile.php" class="list-group-item list-group-item-action active">
                    My Profile
                    <br>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?php echo $user_points ?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user_points ?>%">
                        <?php echo $user_points ?> % Completed
                        </div>
                    </div>
                </a>
                <a href="stud-personal-info.php" class="list-group-item list-group-item-action">
                    Personal Information
                </a>
                <a href="stud-edu-bg.php" class="list-group-item list-group-item-action">
                    Educational Background
                </a>
                <a href="stud-upload-doc.php" class="list-group-item list-group-item-action">
                    Documents
                </a>
            </div>
        </div>

        <!-- right col-->
        <div class="col-sm-9">
            <div class="tab-content">

                <!-- for my profile tab -->
                <div class="tab-pane active px-5" id="myprofile">
                    <hr class="mt-0 mb-4">

                    <form class="form px-5 pt-0" action="" method="post" id="registrationForm">
                        <div class="row mb-2">

                            <!-- name -->
                            <div class="form-group col-lg-12">
                                <label for="name">
                                    <h4>Name</h4>
                                </label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                    value="<?php echo $name ?>">
                            </div>

                            <!-- email -->
                            <div class="form-group col-lg-12">
                                <label for="email">
                                    <h4>Email</h4>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    value="<?php echo $email ?>">
                            </div>

                            <!-- phone number -->
                            <div class="form-group col-lg-12">
                                <label for="phonenumber">
                                    <h4>Phone Number</h4>
                                </label>
                                <input type="number" class="form-control" name="phonenumber" id="phonenumber"
                                    placeholder="Phone Number" value="<?php echo $phonenumber ?>">
                            </div>
                        </div>

                        <!-- button -->
                        <div class="form-group">
                            <div class="col-lg-12 text-right mt-3">
                                <button class="btn btn-lg btn-success" type="submit" name="save-myprofile"><i
                                        class="fa fa-check whiteicon"></i> Save</button>
                                <button class="btn btn-lg" type="reset"><i class="fa fa-redo-alt whiteicon"></i>
                                    Reset</button>
                            </div>
                        </div>
                    </form>
                    <hr class="mt-4 mb-5">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- when clicking the image placeholder for profile -->
<script>
    // when clicking the image placeholder will trigger the input file
    function triggerClick() {
        document.querySelector('#profileImage').click();
    }

    function displayImage(e) {
        // if there is an image
        if (e.files[0]) {
            var reader = new FileReader();

            // change the current image to the ones that has been choosen
            reader.onload = function (e) {
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);

            // display the save button
            $('#save-pict').removeClass('d-none');
        }
    }
</script>