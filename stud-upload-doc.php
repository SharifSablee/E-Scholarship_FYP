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

// Uploads identity card
if (isset($_POST['upload_ic'])) { // if save button on the form is clicked
    $file = $_FILES['uploadIC'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt)); 

    $allowed = array('pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "identityCard_". $id . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "UPDATE stud_profiles SET upload_ic = '$fileName'  WHERE user_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    
                    if ($result) {
                        $_SESSION['status_title'] = "Uploaded!";
                        $_SESSION['status'] = "Your Identity Card has been uploaded";
                        $_SESSION['status_code'] = "success";
        
                        header("Location: stud-upload-doc.php");                    
                    } else {
                        echo "Fail to upload";
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

// Uploads passport photo
if (isset($_POST['upload_photo'])) { // if save button on the form is clicked
    $file = $_FILES['uploadPhoto'];

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
                $fileNameNew = "passportPhoto_". $id . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "UPDATE stud_profiles SET upload_passport_photo = '$fileName'  WHERE user_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    
                    if ($result) {
                        $_SESSION['status_title'] = "Uploaded!";
                        $_SESSION['status'] = "Your Passport Photo has been uploaded";
                        $_SESSION['status_code'] = "success";
        
                        header("Location: stud-upload-doc.php");                    
                    } else {
                        echo "Fail to upload";
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

// to display progress
$query = "SELECT upload_ic, upload_passport_photo
          FROM stud_profiles
          WHERE user_id=$id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    $points = 0;

    if($user['upload_ic'] != "") {
        $points = $points + 1;
    } else {
        $points = $points;
    }

    if($user['upload_passport_photo'] != "") {
        $points = $points + 1;
    } else {
        $points = $points;
    }

    $query1 = "SELECT *
    FROM user_highercert
    WHERE user_id=$id";
    $result1 = mysqli_query($con, $query1);

    if($result1 && mysqli_num_rows($result1) > 0) {
        $user1 = mysqli_fetch_assoc($result1);

        foreach ($result1 as $row) {
            if ($row['upload_doc'] != "") {
                $points = $points + 1;
            } else {
                $points = $points;

            }
        }
    }

    $query2 = "SELECT *
    FROM user_upload_lowercert
    WHERE user_id=$id";
    $result2 = mysqli_query($con, $query2);

    if($result2 && mysqli_num_rows($result2) > 0) {
        $user2 = mysqli_fetch_assoc($result2);

        foreach ($result2 as $row) {
            if ($row['upload_doc'] != "") {
                $points = $points + 1;
            } else {
                $points = $points;

            }
        }
    }

    $doc = 2 + mysqli_num_rows($result1) + mysqli_num_rows($result2);

    $total = round(($points / $doc) * 100);

    if ($total == 99) {
        $total = 100;
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
                
            ?>

            <div class="list-group ml-3">
                <a href="stud-profile.php" class="list-group-item list-group-item-action">
                    My Profile
                </a>
                <a href="stud-personal-info.php" class="list-group-item list-group-item-action">
                    Personal Information
                </a>
                <a href="stud-edu-bg.php" class="list-group-item list-group-item-action">
                    Educational Background
                </a>
                <a href="stud-upload-doc.php" class="list-group-item list-group-item-action active">
                    Documents
                    <br>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?php echo $total ?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $total ?>%">
                        <?php echo $total ?> % Completed
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="tab-content">
                
                <!-- start content -->
                <hr class="mt-0 mb-4">

                <!-- to upload documents -->
                <div class="row">
                    <h4 class="col-lg-10 pl-4"><i class="fas fa-folder-open"></i><b> Documents</b></h4>
                </div>

                <table class="table">
                        <thead>
                            <tr>
                            <th scope="col"><h5><b>Name</b></h5></th>
                            <th scope="col"><h5><b>Documents</b></h5></th>
                            <th scope="col"><h5><b>Action</b></h5></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Identity Card</td>
                                <td>
                                    <?php if ($fetch_pict['upload_ic'] == "") {
                                        echo "Not uploaded yet";
                                    } else {
                                        echo $fetch_pict['upload_ic'];
                                    } ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#icModal">UPLOAD</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Passport Photo</td>
                                <td>
                                    <?php if ($fetch_pict['upload_passport_photo'] == "") {
                                        echo "Not uploaded yet";
                                        } else {
                                            echo $fetch_pict['upload_passport_photo']; 
                                        }
                                    } ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#photoModal">UPLOAD</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Modal for IC -->
                    <div class="modal fade" id="icModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Upload - Identity Card</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="file" name="uploadIC"> <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="upload_ic">UPLOAD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for passport photo -->
                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Upload - Passport Photo</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="file" name="uploadPhoto"> <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="upload_photo">UPLOAD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <!-- to upload higher certificate -->
                <div class="row mt-5">
                    <h4 class="col-lg-10 pl-4"><i class="fas fa-folder-open"></i><b> Higher Certificate</b></h4>
                </div>

                <!-- table to display higher qualifiactions -->
                <div class="my-1">
                    <?php
                        $qualificationH = "SELECT * FROM user_highercert WHERE user_id = $id";
                        $runQH = mysqli_query($con, $qualificationH);

                        if ($runQH && mysqli_num_rows($runQH) > 0) {
                    ?>

                    <table class="table">
                        <thead id="higherthead">
                            <tr>
                                <th scope="col" id="higherth"><h5><b>Name</b></h5></th>
                                <th scope="col" id="higherth"><h5><b>Documents</b></h5></th>
                                <th scope="col"><h5><b>Action</b></h5></th>
                            </tr>
                        </thead>

                        <?php
                                foreach($runQH as $row) {
                        ?>

                        <tbody>
                            <tr>
                                <td><?php echo $row['qualifications'] . " in " . $row['course']; ?></td>
                                <td><?php 
                                    echo $row['upload_doc'];

                                    if ($row['upload_doc'] == null) {
                                        echo "Not uploaded yet";
                                    }
                                 ?></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#highercert">UPLOAD</button></td>

                            </tr>
                        </tbody>

                        <!-- Modal -->
                        <div class="modal fade" id="highercert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title mx-3" id="certModalLabel">Upload - Higher Certificate</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="highercertmodal">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="upload_highercert" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of modal for view button -->

                        <?php
                                }
                            } else {
                                echo "There are no records yet";
                            }
                        ?>

                    </table>
                </div>

                <!-- to upload lower certificate -->
                <div class="row mt-5">
                    <h4 class="col-lg-10 pl-4"><i class="fas fa-folder-open"></i><b> Lower Certificate</b></h4>
                </div>
                
                <!-- table to display lower qualifiactions -->
                <div class="my-1">
                    <?php
                        $qualificationL = "SELECT * FROM user_upload_lowercert WHERE user_id = $id";
                        $runQL = mysqli_query($con, $qualificationL);

                        if ($runQL && mysqli_num_rows($runQL) > 0) {
                    ?>

                    <table class="table">
                        <thead id="lowerthead">
                            <tr>
                                <th scope="col" id="lowerth"><h5><b>Examination</b></h5></th>
                                <th scope="col" id="lowerth"><h5><b>Documents</b></h5></th>
                                <th scope="col"><h5><b>Action</b></h5></th>
                            </tr>
                        </thead>

                        <?php
                                foreach($runQL as $row) {
                        ?>

                        <tbody>
                            <tr>
                                <td><?php echo $row['examination']; ?></td>
                                <td><?php 
                                    echo $row['upload_doc'];

                                    if ($row['upload_doc'] == null) {
                                        echo "Not uploaded yet";
                                    }
                                 ?></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lowercert">UPLOAD</button></td>

                            </tr>
                        </tbody>

                        <!-- Modal -->
                        <div class="modal fade" id="lowercert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title mx-3" id="certModalLabel">Upload - Lower Certificate</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="lowercertmodal">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="upload_lowercert" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of modal for view button -->

                        <?php
                                }
                            } else {
                                echo "There are no records yet";
                            }

                        ?>

                    </table>
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

    // to display modal if click upload button for higher qualification
    $(".btn[data-target='#highercert']").click(function() {
        var columnHeadings = $("#higherthead #higherth").map(function() {
            return $(this).text();
        }).get();

        columnHeadings.pop(); 

        var columnValues = $(this).parent().siblings().map(function() {
            return $(this).text();
        }).get();
        
        var modalBody = $('<div id="modalContent"></div>');
        var modalForm = $('<form role="form" name="modalForm" action="" method="post"></form>');
        
        $.each(columnHeadings, function(i, columnHeader) {
            var formGroup = $('<div class="row mb-3"></div>');
            formGroup.append('<label class="form-group col-lg-12 mx-0" for="'+columnHeader+'"><h4>'+columnValues[i]+'</h4></label>');
            formGroup.append('<input type="file" name="uploaddoc" id="'+columnHeader+i+'" value="'+columnValues[i]+'"/>');
            modalForm.append(formGroup);
            var name = columnValues[i];
        });
    
        modalBody.append(modalForm);
        
        $('#highercertmodal').html(modalBody);
    });
        
    $('.modal-footer .btn-primary').click(function() {
        $('form[name="modalForm"]').submit();
    });

    // to display modal if click upload button for lower qualification
    $(".btn[data-target='#lowercert']").click(function() {
        var columnHeadings = $("#lowerthead #lowerth").map(function() {
            return $(this).text();
        }).get();

        columnHeadings.pop(); 

        var columnValues = $(this).parent().siblings().map(function() {
            return $(this).text();
        }).get();
        
        var modalBody = $('<div id="modalContent"></div>');
        var modalForm = $('<form role="form" name="modalForm" action="" method="post"></form>');
        
        $.each(columnHeadings, function(i, columnHeader) {
            var formGroup = $('<div class="row mb-3"></div>');
            formGroup.append('<label class="form-group col-lg-12 mx-0" for="'+columnHeader+'"><h4>'+columnValues[i]+'</h4></label>');
            formGroup.append('<input type="file" name="uploaddoc" id="'+columnHeader+i+'" value="'+columnValues[i]+'"/>');
            modalForm.append(formGroup);
            var name = columnValues[i];
        });
    
        modalBody.append(modalForm);
        
        $('#lowercertmodal').html(modalBody);
    });
        
    $('.modal-footer .btn-primary').click(function() {
        $('form[name="modalForm"]').submit();
    });
</script>

