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

    $allowed = array('jpg');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "profile_". $id . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "UPDATE stud_profiles SET profile_picture = '$fileNameNew'  WHERE user_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    
                    if ($result) {
                        $_SESSION['status_title'] = "Success!";
                        $_SESSION['status'] = "Profile picture updated!";
                        $_SESSION['status_code'] = "success";
        
                        header("Location: stud-profile.php");                    
                    } else {
                        echo "fail to upload";
                    }
                } else {
                    echo "nda mau move";
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