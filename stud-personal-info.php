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

$profile     = "SELECT * FROM stud_profiles WHERE user_id = $id";
$run_profile = mysqli_query($con, $profile);
if ($run_profile) {
    $fetch_profile = mysqli_fetch_assoc($run_profile);
}

// save the changes made 
if (isset($_POST['save-personalinfo'])) {
    $dob = date('Y-m-d', strtotime($_POST['dob']));
    $pob = $_POST['placebirth'];
    $ic = $_POST['icnumber'];
    $iccolour = $_POST['iccolour'];
    $address = $_POST['per_address'];
    $postcode = $_POST['per_postcode'];
    $pos_address = $_POST['pos_address'];
    $pos_postcode = $_POST['pos_postcode'];
    
    if (isset($_POST['checkbox-address'])) {

        $update = "UPDATE stud_profiles SET 
                    date_of_birth = '$dob', 
                    birth_place = '$pob',
                    ic_number = '$ic',
                    ic_colour = '$iccolour',
                    address = '$address',
                    postcode = '$postcode',
                    postal_address = '$address',
                    postal_postcode = '$postcode'
                    WHERE user_id = $id";

        $run_update = mysqli_query($con, $update);
    
        if ($run_update) {
            $_SESSION['status_title'] = "Success!";
            $_SESSION['status'] = "Your profile has been updated!";
            $_SESSION['status_code'] = "success";

        } else {
            $_SESSION['status_title'] = "Opps...";
            $_SESSION['status'] = "Your profile is not updated";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $update = "UPDATE stud_profiles SET 
        date_of_birth = '$dob', 
        birth_place = '$pob',
        ic_number = '$ic',
        ic_colour = '$iccolour',
        address = '$address',
        postcode = '$postcode',
        postal_address = '$pos_address',
        postal_postcode = '$pos_postcode'
        WHERE user_id = $id";

        $run_update = mysqli_query($con, $update);

        if ($run_update) {
        $_SESSION['status_title'] = "Success!";
        $_SESSION['status'] = "Your profile has been updated!";
        $_SESSION['status_code'] = "success";
        header("Location: stud-personal-info.php");

        } else {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Your profile is not updated";
        $_SESSION['status_code'] = "error";
        }
    }

}

// to display progress
$query = "SELECT date_of_birth, birth_place, ic_number, ic_colour, address, postcode, postal_address, postal_postcode
          FROM stud_profiles
          WHERE user_id=$id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $maximumPoints = 100;
    $user_points = 0;

    if ($user['date_of_birth'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['birth_place'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['ic_number'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['ic_colour'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['address'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['postcode'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['postal_address'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['postal_postcode'] != null) {
        $user_points = $user_points + 12;
    } else {
        $user_points = $user_points;
    }

    if ($user['date_of_birth'] != null && $user['birth_place'] != null && $user['ic_number'] != null && $user['ic_colour'] != null
    && $user['address'] != null && $user['postcode'] != null && $user['postal_address'] != null && $user['postal_postcode'] != null) {
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
                <a href="stud-profile.php" class="list-group-item list-group-item-action">
                    My Profile
                </a>
                <a href="stud-personal-info.php" class="list-group-item list-group-item-action active">
                    Personal Information
                    <br>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?php echo $user_points ?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user_points ?>%">
                        <?php echo $user_points ?> % Completed
                        </div>
                    </div>
                </a>
                <a href="stud-edu-bg.php" class="list-group-item list-group-item-action">
                    Educational Background
                </a>
                <a href="stud-upload-doc.php" class="list-group-item list-group-item-action">
                    Documents
                </a>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="tab-content">
                
                <!-- start content -->
                <!-- for personal information tab -->
                <div class="active tab-pane px-5" id="personalinfo">
                    <hr class="mt-0 mb-4">
                    <form class="form px-5 pt-0" action="" method="post" id="registrationForm">
                        <div class="row mb-2">

                            <!-- date of birth -->
                            <div class="form-group col-lg-6">
                                <label for="dob">
                                    <h4>Date of Birth</h4>
                                </label>
                                <?php
                                    if ($fetch_profile['date_of_birth'] == "0000-00-00") {
                                        echo "<input class='form-control' id='dob' name='dob' placeholder='Date of Birth' type='date' autocomplete='off' />";
                                    } else {
                                        echo "<input class='form-control' id='dob' name='dob' placeholder='Date of Birth' type='date' value='" . $fetch_profile['date_of_birth'] . "' />";
                                    }
                                ?>
                            </div>

                            <!-- place of birth -->
                            <div class="form-group col-lg-6">
                                <label for="placebirth">
                                    <h4>Place of Birth</h4>
                                </label>
                                <?php
                                    if ($fetch_profile['birth_place'] == "") {
                                        echo "<input type='text' class='form-control' name='placebirth' id='placebirth' placeholder='Place of Birth'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='placebirth' id='placebirth' placeholder='Place of Birth' value='" . $fetch_profile['birth_place'] . "' />";
                                    }
                                ?>
                            </div>

                            <!-- ic number -->
                            <div class="form-group col-lg-12">
                                <label for="icnumber">
                                    <h4>IC Number</h4>
                                </label>
                                <?php
                                    if ($fetch_profile['ic_number'] == "") {
                                        echo "<input type='number' class='form-control' name='icnumber' id='icnumber' placeholder='example: 01123456'>";
                                    } else {
                                        echo "<input type='number' class='form-control' name='icnumber' id='icnumber' placeholder='example: 01123456' value='" . $fetch_profile['ic_number'] . "' />";
                                    }
                                ?>
                            </div>

                            <!-- ic colour -->
                            <div class="form-group col-lg-12">
                                <label for="colour">
                                    <h4>Colour</h4>
                                </label>
                                <!-- select -->
                                <div class="">
                                    <?php
                                        if ($fetch_profile['ic_colour'] == "") {
                                            echo "<select class='form-select form-control' id='iccolour' name='iccolour' aria-label='Default select example'>
                                                <option value='' disabled selected hidden>Choose Colour</option>
                                                <option value='yellow'>Yellow</option>
                                                <option value='purple'>Purple</option>
                                                <option value='green'>Green</option>
                                                </select>";
                                        } else if ($fetch_profile['ic_colour'] == "yellow") {
                                            echo "<select class='form-select form-control' id='iccolour' name='iccolour' aria-label='Default select example'>
                                                <option value='yellow' selected>Yellow</option>
                                                <option value='purple'>Purple</option>
                                                <option value='green'>Green</option>
                                                </select>";
                                        } else if ($fetch_profile['ic_colour'] == "purple") {
                                            echo "<select class='form-select form-control' id='iccolour' name='iccolour' aria-label='Default select example'>
                                                <option value='yellow'>Yellow</option>
                                                <option value='purple' selected>Purple</option>
                                                <option value='green'>Green</option>
                                                </select>";
                                        } else if ($fetch_profile['ic_colour'] == "green") {
                                            echo "<select class='form-select form-control' id='iccolour' name='iccolour' aria-label='Default select example'>
                                                <option value='yellow'>Yellow</option>
                                                <option value='purple'>Purple</option>
                                                <option value='green' selected>Green</option>
                                                </select>";
                                        }
                                    ?>
                                </div>
                            </div>

                            <!-- permanent address -->
                            <div class="form-group col-lg-12">
                                <label for="per_address">
                                    <h4>Permanent Address</h4>
                                </label>
                                <?php
                                    if ($fetch_profile['address'] == "") {
                                        echo "<textarea method='post' name='per_address' id='per_address' rows='3' class='form-control' placeholder='Permanent Address'></textarea>";
                                    } else {
                                        echo "<textarea name='per_address' id='per_address' rows='3' class='form-control' placeholder='Permanent Address'>" . $fetch_profile['address'] . "</textarea>";
                                    }
                                ?>
                            </div>

                            <!-- post code -->
                            <div class="form-group col-lg-6">
                                <label for="per_postcode">
                                    <h4>Post Code</h4>
                                </label>
                                <?php
                                    if (empty($fetch_profile['postcode'])) {
                                        echo "<input type='text' class='form-control' name='per_postcode' id='per_postcode' placeholder='Post Code'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='per_postcode' id='per_postcode' placeholder='Post Code' value='" . $fetch_profile['postcode'] . "' />";
                                    }
                                ?>
                            </div>

                            <!-- postal address -->
                            <div class="form-group col-lg-12 mt-4 mb-4">
                                <label for="checkbox">Please tick if <b>Postal Address</b> is the same as <b>Permanent Address</b></label>
                                <?php
                                    if ($fetch_profile['address'] == $fetch_profile['postal_address'] && $fetch_profile['address'] != "") {
                                        echo "<input type='checkbox' name='checkbox-address' id='checkbox-address' onchange='valueChanged()' checked>";
                                    } else {
                                        echo "<input type='checkbox' name='checkbox-address' id='checkbox-address' onchange='valueChanged()'>";
                                    }
                                ?>
                            </div>

                            <!-- postal address -->
                            <div class="form-group col-lg-12" id="postal_address">
                                <label for="pos_address">
                                    <h4>Postal Address</h4>
                                </label>
                                <?php
                                    if ($fetch_profile['postal_address'] == "") {
                                        echo "<textarea method='post' name='pos_address' id='pos_address' rows='3' class='form-control' placeholder='Postal Address'></textarea>";
                                    } else {
                                        echo "<textarea name='pos_address' id='pos_address' rows='3' class='form-control' placeholder='Postal Address'>" . $fetch_profile['postal_address'] . "</textarea>";
                                    }
                                ?>
                            </div>

                            <!-- post code -->
                            <div class="form-group col-lg-6" id="postal_postcode">
                                <label for="pos_postcode">
                                    <h4>Post Code</h4>
                                </label>
                                <?php
                                    if (empty($fetch_profile['postal_postcode'])) {
                                        echo "<input type='text' class='form-control' name='pos_postcode' id='pos_postcode' placeholder='Post Code'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='pos_postcode' id='pos_postcode' placeholder='Post Code' value='" . $fetch_profile['postal_postcode'] . "' />";
                                    }
                                ?>
                            </div>

                        </div>

                        <!-- button -->
                        <div class="form-group">
                            <div class="col-lg-12 text-right mt-3">
                                <button class="btn btn-lg btn-success" type="submit" name="save-personalinfo"><i
                                        class="fa fa-check whiteicon"></i> Save</button>
                                <button class="btn btn-lg" type="reset"><i class="fa fa-redo-alt whiteicon"></i>
                                    Reset</button>
                            </div>
                        </div>
                    </form>
                    <hr class="mt-4 mb-5">
                </div>

                <!-- end content -->
            </div>
        </div>
    </div>
</div>

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

    // datepicker calendar
    // $(document).ready(function () {
    //     var date_input = $('input[name="dob"]'); //our date input has the name "date"
    //     var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form')
    //         .parent() : "body";
    //     var options = {
    //         format: 'd M yyyy',
    //         container: container,
    //         todayHighlight: true,
    //         autoclose: true,
    //     };
    //     date_input.datepicker(options);
    // })

    // hide postal address if check
    function valueChanged() {
        if (document.getElementById('checkbox-address').checked) {
            document.getElementById("postal_address").style.display = 'none';
            document.getElementById("postal_postcode").style.display = 'none';
            document.getElementById("postal_district").style.display = 'none';
        } else {
            document.getElementById("postal_address").style.display = 'block';
            document.getElementById("postal_postcode").style.display = 'block';
            document.getElementById("postal_district").style.display = 'block';
        }
    }
</script>