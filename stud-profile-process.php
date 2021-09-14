<?php
require_once('db.php');
$id = $_SESSION['id'];

// to upload profile picture
if (isset($_POST['save-pict'])) {

    $file = $_FILES['profileImage'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "profile_". $id . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "UPDATE stud_profiles SET profile_picture = '$fileNameNew'  WHERE user_id = $id";
                    $result = mysqli_query($con, $sql);
    
                    $_SESSION['status_title'] = "Success!";
                    $_SESSION['status'] = "Profile picture updated!";
                    $_SESSION['status_code'] = "success";
    
                    header("Location: stud-profile.php");

                } else {
                    echo "fail to upload";
                }

            } else {
                $_SESSION['status_title'] = "Error!";
                $_SESSION['status'] = "File is too big!";
                $_SESSION['status_code'] = "error";
            }
        } else {
            echo "error uploading your file";
            $_SESSION['status_title'] = "Opps...";
            $_SESSION['status'] = "There is something wrong";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status_title'] = "Error!";
        $_SESSION['status'] = "Invalid Type!";
        $_SESSION['status_code'] = "error";
    }
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

        } else {
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Your profile is not updated";
        $_SESSION['status_code'] = "error";
        }
    }

}