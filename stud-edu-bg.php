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

if(isset($_POST['save-highercert'])) {

    if ($_POST['qualifications'] == "othersQ" && $_POST['course'] == "othersC") {
        $qualifications = $_POST['otherQ'];
        $course = $_POST['otherC'];
        $result = $_POST['result'];
        $year = $_POST['year'];
        $institutions = $_POST['institutions'];
    } else if ($_POST['qualifications'] == "othersQ") {
        $qualifications = $_POST['otherQ'];
        $course = $_POST['course'];
        $result = $_POST['result'];
        $year = $_POST['year'];
        $institutions = $_POST['institutions'];
    } else if ($_POST['course'] == "othersC") {
        $qualifications = $_POST['qualifications'];
        $course = $_POST['otherC'];
        $result = $_POST['result'];
        $year = $_POST['year'];
        $institutions = $_POST['institutions'];
    } else {
        $qualifications = $_POST['qualifications'];
        $course = $_POST['course'];
        $result = $_POST['result'];
        $year = $_POST['year'];
        $institutions = $_POST['institutions'];
    }

    $query1 = "INSERT INTO user_highercert (user_id, qualifications, course, result, year, institutions) VALUES ('$id', '$qualifications', '$course', '$result', '$year', '$institutions')";
    $runquery = mysqli_query($con, $query1);
    if ($runquery){
        $_SESSION['status_title'] = "Success!";
        $_SESSION['status'] = "Your profile has been updated!";
        $_SESSION['status_code'] = "success";
        header("Location: stud-edu-bg.php");
    }
    else{
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Your profile is not updated";
        $_SESSION['status_code'] = "error";
        header("Location: stud-edu-bg.php");
    }
}

if (isset($_POST['deleteBtn'])) {
    echo "delete";
    $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Your profile is not updated";
        $_SESSION['status_code'] = "error";
}

// to delete higher cert
if(isset($_GET['higher_id']))
{
     $sql_query="DELETE FROM user_highercert WHERE id =".$_GET['higher_id'];
     mysqli_query($con, $sql_query);
     header("Location: stud-edu-bg.php");
}

// to display progress
$query = "SELECT *
          FROM user_highercert
          WHERE user_id=$id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
   $user_points = 100;
} else {
    $user_points = 0;
}

// SAVING LOWER CERT
if(isset($_POST['save-lowercert'])) {

    $examination = $_POST['examination'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    $query2 = "INSERT INTO user_lowercert (user_id, examination, subject, grade) VALUES ('$id', '$examination', '$subject', '$grade')";
    $runquery2 = mysqli_query($con, $query2);
    if ($runquery2){
        $check = "SELECT * FROM user_upload_lowercert WHERE user_id = $id";
        $runCheck = mysqli_query($con, $check);

        if ($runCheck) {
            if ($runCheck && mysqli_num_rows($runCheck) >= 0) {
                $checks = "SELECT * FROM user_upload_lowercert WHERE examination = '$examination' limit 1";
                if(mysqli_query($con, $checks) && mysqli_num_rows(mysqli_query($con, $checks)) == 0) {
                    $lowercert = "INSERT INTO user_upload_lowercert (user_id, examination) VALUES ('$id', '$examination')";
                    mysqli_query($con, $lowercert);
                }
                
                $_SESSION['status_title'] = "Success!";
                $_SESSION['status'] = "Your profile has been updated!";
                $_SESSION['status_code'] = "success";
                header("Location: stud-edu-bg.php");
                
            }
        }      
    }
    else{
        $_SESSION['status_title'] = "Opps...";
        $_SESSION['status'] = "Your profile is not updated";
        $_SESSION['status_code'] = "error";
        header("Location: stud-edu-bg.php");
    }
}

// to delete lower cert
if(isset($_GET['lower_id']))
{
     $sql_query="DELETE FROM user_lowercert WHERE id =".$_GET['lower_id'];
     mysqli_query($con, $sql_query);
     header("Location: stud-edu-bg.php");
}

// check lower cert GCE A LEVEL
$checkGCEA = "SELECT * FROM user_lowercert WHERE user_id = $id AND examination = 'GCE A Level'";
$run = mysqli_query($con, $checkGCEA);

if ($run && mysqli_num_rows($run) == 0) {
    $delete = "DELETE FROM user_upload_lowercert WHERE user_id = $id AND examination = 'GCE A Level'";
    mysqli_query($con, $delete);
}   

// check lower cert GCE O LEVEL
$checkGCEO = "SELECT * FROM user_lowercert WHERE user_id = $id AND examination = 'GCE O Level'";
$run = mysqli_query($con, $checkGCEO);

if ($run && mysqli_num_rows($run) == 0) {
    $delete = "DELETE FROM user_upload_lowercert WHERE user_id = $id AND examination = 'GCE O Level'";
    mysqli_query($con, $delete);
} 

// check lower cert IGCSE A LEVEL
$checkIGCSEA = "SELECT * FROM user_lowercert WHERE user_id = $id AND examination = 'IGCSE A Level'";
$run = mysqli_query($con, $checkIGCSEA);

if ($run && mysqli_num_rows($run) == 0) {
    $delete = "DELETE FROM user_upload_lowercert WHERE user_id = $id AND examination = 'IGCSE A Level'";
    mysqli_query($con, $delete);
}   

// check lower cert IGCSE O LEVEL
$checkIGCSEO = "SELECT * FROM user_lowercert WHERE user_id = $id AND examination = 'IGCSE O Level'";
$run = mysqli_query($con, $checkIGCSEO);

if ($run && mysqli_num_rows($run) == 0) {
    $delete = "DELETE FROM user_upload_lowercert WHERE user_id = $id AND examination = 'IGCSE O Level'";
    mysqli_query($con, $delete);
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
                <a href="stud-personal-info.php" class="list-group-item list-group-item-action">
                    Personal Information
                </a>
                <a href="stud-edu-bg.php" class="list-group-item list-group-item-action active">
                    Educational Background
                    <br>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?php echo $user_points ?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user_points ?>%">
                        <?php echo $user_points ?> % Completed
                        </div>
                    </div>
                </a>
                <a href="stud-upload-doc.php" class="list-group-item list-group-item-action">
                    Documents
                </a>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="tab-content">
                
                <!-- start content -->
                <hr class="mt-0 mb-4">

                <!-- Button trigger modal -->
                <div class="row">
                    <h4 class="col-lg-10 pl-4"><i class="fas fa-graduation-cap"></i><b> Higher Education Qualifications</b></h4>
                    <button type="button" class="btn btn-primary col-lg-1" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title mx-3" id="exampleModalLabel"><i class="fas fa-graduation-cap"></i> Higher Education Qualification</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="POST" class="mx-3">
                                <div class="modal-body">
                                        <!-- qualifications -->
                                        <div class="mb-3 row">
                                            <label for="qualifications" class="form-group col-lg-4"><h4>Qualifications:</h4></label>
                                            <select class="form-select form-control col-lg-7 mx-4" id='qualifications' name='qualifications' onchange="yesnoCheck(this)">
                                                <option value='' disabled selected hidden>Select Qualifications</option>
                                                <option value="Advanced Diploma">Advanced Diploma</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Higher National Diploma">Higher National Diploma</option>
                                                <option value="Higher National Technical Education Certificate">Higher National Technical Education Certificate</option>
                                                <option value="National Technical Education Certificate">National Technical Education Certificate</option>
                                                <option value="othersQ">Others</option>
                                            </select>
                                        </div>

                                        <!-- others for qualifications -->
                                        <div class="mb-3 row" id="ifYesQ" style="display: none;">
                                            <label for="otherQ" class="form-group col-lg-4"></label>
                                            <input type="text" class="form-control col-lg-7 mx-4 mb-3" id="otherQ" name="otherQ" placeholder="Please State">
                                        </div>

                                        <!-- course -->
                                        <div class="mb-3 row">
                                            <label for="course" class="form-group col-lg-4"><h4>Course:</h4></label>
                                            <select id='course' name='course' class="form-select form-control col-lg-7 mx-4" onchange="yesNoCheck(this)">
                                                <option value='' disabled selected hidden>Select Courses
                                                </option>
                                                <option value="Agrotechnology">Agrotechnology</option>
                                                <option value="Aircraft Maintenance Engineering (Airframe and Engine)">Aircraft Maintenance Engineering (Airframe and Engine)
                                                </option>
                                                <option value="Aircraft Maintenance Engineering (Avionics)">Aircraft Maintenance Engineering (Avionics)</option>
                                                <option value="Aquaculture">Aquaculture</option>
                                                <option value="Architecture">Architecture</option>
                                                <option value="Assistant Nurse (General Nursing)">Assistant Nurse (General Nursing)</option>
                                                <option value="Automobile Technology">Automobile Technology
                                                </option>
                                                <option value="Automotive Technician">Automotive Technician
                                                </option>
                                                <option value="Blasting and Painting (Oil and Gas Industry)">Blasting and Painting (Oil and Gas Industry)</option>
                                                <option value="Building Craft">Building Craft</option>
                                                <option value="Building Services Engineering">Building Services Engineering</option>
                                                <option value="Business Accounting & Finance">Business Accounting & Finance</option>
                                                <option value="Business Studies">Business Studies</option>
                                                <option value="Business Studies (Entrepreneurship)">Business Studies (Entrepreneurship)</option>
                                                <option value="Business Studies (Human Resource Management)">Business Studies (Human Resource Management)</option>
                                                <option value="Business Studies (Marketing)">Business Studies (Marketing)</option>
                                                <option value="Business and Administration">Business and Administration</option>
                                                <option value="Business and Finance">Business and Finance
                                                </option>
                                                <option value="Chemical Engineering">Chemical Engineering
                                                </option>
                                                <option value="Civil Engineering">Civil Engineering</option>
                                                <option value="Computer Networking">Computer Networking
                                                </option>
                                                <option value="Construction and Draughting (Dual Tvet)">Construction and Draughting (Dual Tvet)</option>
                                                <option value="Control and Automation Engineering (Hengyi)">Control and Automation Engineering (Hengyi)</option>
                                                <option value="Crop and Livestock Production">Crop and Livestock Production</option>
                                                <option value="Culinary Operations">Culinary Operations
                                                </option>
                                                <option value="Data Analytics">Data Analytics</option>
                                                <option value="Deck Rating">Deck Rating</option>
                                                <option value="Dental Assisting">Dental Assisting</option>
                                                <option value="Digital Media">Digital Media</option>
                                                <option value="Electrical Engineering">Electrical Engineering</option>
                                                <option value="Electrical Technology">Electrical Technology
                                                </option>
                                                <option value="Electrical and Electronic Engineering">Electrical and Electronic Engineering</option>
                                                <option value="Electronic Engineering">Electronic Engineering</option>
                                                <option value="Electronics and Communications Engineering">Electronics and Communications Engineering</option>
                                                <option value="Electronics and Media Technology">Electronics and Media Technology</option>
                                                <option value="Engine Rating">Engine Rating</option>
                                                <option value="Food Processing">Food Processing</option>
                                                <option value="Health Science (Cardiovascular Technology)">Health Science (Cardiovascular Technology)</option>
                                                <option value="Health Science (Dental Hygiene & Therapy)">Health Science (Dental Hygiene & Therapy)</option>
                                                <option value="Health Science (Environmental Health)">Health Science (Environmental Health)</option>
                                                <option value="Health Science (Midwifery)">Health Science (Midwifery)</option>
                                                <option value="Health Science (Nursing)">Health Science (Nursing)</option>
                                                <option value="Health Science (Paramedics)">Health Science (Paramedics)</option>
                                                <option value="Heavy Vehicle Mechanics">Heavy Vehicle Mechanics</option>
                                                <option value="Hospitality Operations">Hospitality Operations</option>
                                                <option value="Industrial Equipment Maintenance">Industrial Equipment Maintenance</option>
                                                <option value="Industrial Machining & Maintenance">Industrial Machining & Maintenance</option>
                                                <option value="Information Systems">Information Systems
                                                </option>
                                                <option value="Information Technology">Information Technology</option>
                                                <option value="Information and Library Studies">Information and Library Studies</option>
                                                <option value="Instrumentation and Control Engineering">Instrumentation and Control Engineering</option>
                                                <option value="Interior Design">Interior Design</option>
                                                <option value="It Network">IT Network</option>
                                                <option value="Laboratory Science">Laboratory Science
                                                </option>
                                                <option value="Library Informatics Computing">Library Informatics Computing</option>
                                                <option value="Light Vehicle Mechanics">Light Vehicle Mechanics</option>
                                                <option value="Marine Engineering">Marine Engineering
                                                </option>
                                                <option value="Markinga Nd Fitting (Oil and Gas Industry)">Markinga Nd Fitting (Oil and Gas Industry)</option>
                                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                                <option value="Nautical Studies">Nautical Studies</option>
                                                <option value="Office Administration">Office Administration
                                                </option>
                                                <option value="Petroleum Engineering">Petroleum Engineering
                                                </option>
                                                <option value="Pharmacy Technician">Pharmacy Technician
                                                </option>
                                                <option value="Plant Engineering">Plant Engineering</option>
                                                <option value="Professional Cookery & Services">Professional Cookery & Services</option>
                                                <option value="Real Estate Management and Agency">Real Estate Management and Agency</option>
                                                <option value="Refinery Operator (Hengyi)">Refinery Operator (Hengyi)</option>
                                                <option value="Refrigeration and Air-conditioning">Refrigeration and Air-conditioning</option>
                                                <option value="Rigging (Oil and Gas Industry)">Rigging (Oil and Gas Industry)</option>
                                                <option value="Rooms Division Operations">Rooms Division Operations</option>
                                                <option value="Scaffolding (Oil and Gas Industry)">Scaffolding (Oil and Gas Industry)</option>
                                                <option value="Science Technology">Science Technology
                                                </option>
                                                <option value="Telecommunication and System Engineering">Telecommunication and System Engineering</option>
                                                <option value="Travel and Tourism">Travel and Tourism
                                                </option>
                                                <option value="Web Development">Web Development</option>
                                                <option value="Welding">Welding</option>
                                                <option value="Welding (Oil and Gas Industry)">Welding (Oil and Gas Industry)</option>
                                                <option value="othersC">Others</option>
                                            </select>
                                        </div>

                                        <!-- others for course -->
                                        <div class="mb-3 row" id="ifYesC" style="display: none;">
                                            <label for="otherC" class="form-group col-lg-4"></label>
                                            <input type="text" class="form-control col-lg-7 mx-4 mb-3" id="otherC" name="otherC" placeholder="Please State">
                                        </div>

                                        <!-- result -->
                                        <div class="mb-3 row">
                                            <label for="result" class="form-group col-lg-4"><h4>Result:</h4></label>
                                            <select id='result' name='result' class="form-select form-control col-lg-7 mx-4">
                                                <option value='' disabled selected hidden>Please Choose</option>
                                                <option value="P">Pass</option>
                                                <option value="F">Fail</option>
                                            </select>
                                        </div>

                                        <!-- year -->
                                        <div class="mb-3 row">
                                            <label for="year" class="form-group col-lg-4"><h4>Year:</h4></label>
                                            <input type="text" class="form-control col-lg-7 mx-4" id="year" name="year" placeholder="Please State">
                                        </div>

                                        <!-- institutions -->
                                        <div class="mb-3 row">
                                            <label for="institutions" class="form-group col-lg-4"><h4>Institutions:</h4></label>
                                            <select id='institutions' name='institutions' class='form-select form-control col-lg-7 mx-4'>
                                                <option value='' disabled selected hidden>Select Institutions</option>
                                                <option value="Institute Brunei Technical Education">Institute Brunei Technical Education</option>
                                                <option value="Politeknik Brunei">Politeknik Brunei</option>
                                                <option value="University Brunei Darussalam">University Brunei Darussalam</option>
                                                <option value="University Islam Sultan Sharif Ali">University Islam Sultan Sharif Ali</option>
                                                <option value="University Technology Brunei">University Technology Brunei</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="save-highercert" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of modal -->

                <!-- table to display higher qualifiactions -->
                <div class="my-4">
                    <?php
                        $qualificationH = "SELECT * FROM user_highercert WHERE user_id = $id";
                        $runQH = mysqli_query($con, $qualificationH);

                        if ($runQH && mysqli_num_rows($runQH) > 0) {
                    ?>

                    <table class="table">
                        <thead id="higherthead">
                            <tr>
                            <th scope="col" id="higherth"><h5><b>Qualifications</b></h5></th>
                            <th scope="col" id="higherth"><h5><b>Course</b></h5></th>
                            <th scope="col" id="higherth"><h5><b>Result</b></h5></th>
                            <th scope="col" id="higherth" style="display:none;"><h5><b>Year</b></h5></th>
                            <th scope="col" id="higherth" style="display:none;"><h5><b>Institutions</b></h5></th>
                            <th scope="col" id="higherth" colspan="2"><h5><b>Action</b></h5></th>
                            </tr>
                        </thead>

                        <?php
                                foreach($runQH as $row) {
                        ?>

                        <tbody>
                            <tr>
                                <td><?php echo $row['qualifications']; ?></td>
                                <td><?php echo $row['course']; ?></td>
                                <td><?php echo $row['result']; ?></td>
                                <td style="display:none;"><?php echo $row['year']; ?></td>
                                <td style="display:none;"><?php echo $row['institutions']; ?></td>
                                <td><button class="btn btn-outline-success viewBtn" data-toggle="modal" data-target="#viewmodal">View</button></td>
                                <td><a class="btn btn-outline-danger" href="javascript:higher_id(<?php echo $row['id']; ?>)">X</a></td>
                            </tr>
                        </tbody>

                        <?php
                                }
                            } else {
                                echo "There are no records yet";
                            }
                        ?>

                    </table>
                </div>

                <!-- start of modal for view button -->
                <!-- Modal -->
                <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title mx-3" id="viewModalLabel"><i class="fas fa-graduation-cap"></i> Higher Education Qualification</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modaledit">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of modal for view button -->

<!-- ############################################# Lower education ################################################# -->

                <!-- Button trigger modal -->
                <div class="row pt-4">
                    <h4 class="col-lg-10 pl-4"><i class="fas fa-graduation-cap"></i><b> Lower Education Qualifications</b></h4>
                    <button type="button" class="btn btn-primary col-lg-1" data-bs-toggle="modal" data-bs-target="#lowermodal">+</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="lowermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title mx-3" id="exampleModalLabel"><i class="fas fa-graduation-cap"></i> Lower Education Qualification</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="POST" class="mx-3">
                                <div class="modal-body">

                                    <!-- examination -->
                                    <div class="mb-3 row">
                                        <label for="examination" class="form-group col-lg-4"><h4>Examination:</h4></label>
                                        <select id='examination' name='examination' class="form-select form-control col-lg-7 mx-4">
                                            <option value='' disabled selected hidden>Select Examination</option>
                                            <option value="GCE A Level">GCE A Level</option>
                                            <option value="GCE O Level">GCE O Level</option>
                                            <option value="IGCSE A Level">IGCSE A Level</option>
                                            <option value="IGCSE O Level">IGCSE O Level</option>
                                        </select>
                                    </div>

                                    <!-- subject -->
                                    <div class="mb-3 row">
                                        <label for="subject" class="form-group col-lg-4"><h4>Subject:</h4></label>
                                        <select id='subject' name='subject' class="form-select form-control col-lg-7 mx-4">
                                            <option value='' disabled selected hidden>Select Subject</option>
                                            <option value="Accounting">Accounting</option>
                                            <option value="Additional Mathematics">Additional Mathematics</option>
                                            <option value="Agriculture">Agriculture</option>
                                            <option value="American History">American History</option>
                                            <option value="Arabic">Arabic</option>
                                            <option value="Arabic - First Language">Arabic - First Language</option>
                                            <option value="Arabic - Foreign Language">Arabic - Foreign Language</option>
                                            <option value="Art & Design">Art & Design</option>
                                            <option value="Biology">Biology</option>
                                            <option value="Business Studies">Business Studies</option>
                                            <option value="Chemistry">Chemistry</option>
                                            <option value="Chinese - First Language">Chinese - First Language</option>
                                            <option value="Chinese - Second Language">Chinese - Second Language</option>
                                            <option value="Combined Science">Combined Science</option>
                                            <option value="Commerce">Commerce</option>
                                            <option value="Computer Science">Computer Science</option>
                                            <option value="Design & Technology">Design & Technology</option>
                                            <option value="Design and Communication">Design and Communication</option>
                                            <option value="Development Studies">Development Studies</option>
                                            <option value="Drama">Drama</option>
                                            <option value="Economics">Economics</option>
                                            <option value="English">English</option>
                                            <option value="English Language">English Language</option>
                                            <option value="English Literature">English Literature</option>
                                            <option value="English as a Second Language">English as a Second Language</option>
                                            <option value="Enterprise">Enterprise</option>
                                            <option value="Environmental Management">Environmental Management</option>
                                            <option value="Food & Nutrition">Food & Nutrition</option>
                                            <option value="French">French</option>
                                            <option value="Geography">Geography</option>
                                            <option value="German">German</option>
                                            <option value="Global Perspectives">Global Perspectives</option>
                                            <option value="Greek">Greek</option>
                                            <option value="Hindi">Hindi</option>
                                            <option value="History">History</option>
                                            <option value="Indonesian Language">Indonesian Language</option>
                                            <option value="Information & Communication Technology">Information & Communication Technology</option>
                                            <option value="International Mathematics">International Mathematics</option>
                                            <option value="Islamic Studies">Islamic Studies</option>
                                            <option value="Islamiyat">Islamiyat</option>
                                            <option value="Italian">Italian</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="Literature in English">Literature in English</option>
                                            <option value="Malay - First Language">Malay - First Language</option>
                                            <option value="Malay - Foreign Language">Malay - Foreign Language</option>
                                            <option value="Marine Science">Marine Science</option>
                                            <option value="Mathematics">Mathematics</option>
                                            <option value="Mathematics D">Mathematics D</option>
                                            <option value="Music">Music</option>
                                            <option value="Physical Science">Physical Science</option>
                                            <option value="Physics">Physics</option>
                                            <option value="Religious Studies">Religious Studies</option>
                                            <option value="Sociology">Sociology</option>
                                            <option value="Spanish">Spanish</option>
                                            <option value="Statistics">Statistics</option>
                                            <option value="Travel & Tourism">Travel & Tourism</option>
                                            <option value="World Literature">World Literature</option>
                                        </select>
                                    </div>

                                    <!-- grade -->
                                    <div class="mb-3 row">
                                        <label for="grade" class="form-group col-lg-4"><h4>Grade:</h4></label>
                                        <select id='grade' name='grade' class="form-select form-control col-lg-7 mx-4">
                                            <option value='' disabled selected hidden>Select Grade</option>
                                            <option value="A1">A1</option>
                                            <option value="A2">A2</option>
                                            <option value="B3">B3</option>
                                            <option value="B4">B4</option>
                                            <option value="C5">C5</option>
                                            <option value="C6">C6</option>
                                            <option value="D7">D7</option>
                                            <option value="E8">E8</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="save-lowercert" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end of modal -->

                <!-- table to display lower qualifiactions -->
                <div class="my-4">
                    <?php
                        $qualificationL = "SELECT * FROM user_lowercert WHERE user_id = $id";
                        $runQL = mysqli_query($con, $qualificationL);

                        if ($runQL && mysqli_num_rows($runQL) > 0) {
                    ?>

                    <table class="table">
                        <thead id="lowerthead">
                            <tr>
                            <th scope="col" id="lowerth"><h5><b>Examination</b></h5></th>
                            <th scope="col" id="lowerth"><h5><b>Subject</b></h5></th>
                            <th scope="col" id="lowerth"><h5><b>Grade</b></h5></th>
                            <th scope="col" id="lowerth" colspan="2"><h5><b>Action</b></h5></th>
                            </tr>
                        </thead>

                        <?php
                                foreach($runQL as $row) {
                        ?>

                        <tbody>
                            <tr>
                                <td><?php echo $row['examination']; ?></td>
                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $row['grade']; ?></td>
                                <td><button class="btn btn-outline-success viewBtn" data-toggle="modal" data-target="#viewmodalLower">View</button></td>
                                <td><a class="btn btn-outline-danger" href="javascript:lower_id(<?php echo $row['id']; ?>)">X</a></td>
                            </tr>
                        </tbody>

                        <?php
                                }
                            } else {
                                echo "There are no records yet";
                            }
                        ?>

                    </table>
                </div>

                <!-- start of modal for view button for lower -->
                <!-- Modal -->
                <div class="modal fade" id="viewmodalLower" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title mx-3" id="viewModalLabel"><i class="fas fa-graduation-cap"></i> Lower Education Qualification</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modaleditLower">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of modal for view button Lower -->

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
    // display input if choose other for qualifiactions
    function yesnoCheck(that) {
        if (that.value == "othersQ") {
            document.getElementById("ifYesQ").style.display = "";
        } else {
            document.getElementById("ifYesQ").style.display = "none";
        }
    }

    // display input if choose other for courses
    function yesNoCheck(that) {
        if (that.value == "othersC") {
            document.getElementById("ifYesC").style.display = "";
        } else {
            document.getElementById("ifYesC").style.display = "none";
        }
    }

    // to display modal if click edit button
    $(".btn[data-target='#viewmodal']").click(function() {
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
            formGroup.append('<label class="form-group col-lg-4 ml-3" for="'+columnHeader+'"><h4>'+columnHeader+'</h4></label>');
            formGroup.append('<input class="form-control col-lg-7 mx-4 mb-3" name="'+columnHeader+i+'" id="'+columnHeader+i+'" value="'+columnValues[i]+'" readonly />'); 
            modalForm.append(formGroup);
        });
    
        modalBody.append(modalForm);
        
        $('#modaledit').html(modalBody);
    });
        
    $('.modal-footer .btn-primary').click(function() {
        $('form[name="modalForm"]').submit();
    });

    // to display modal if click edit button for lower qualification
    $(".btn[data-target='#viewmodalLower']").click(function() {
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
            formGroup.append('<label class="form-group col-lg-4 ml-3" for="'+columnHeader+'"><h4>'+columnHeader+'</h4></label>');
            formGroup.append('<input class="form-control col-lg-7 mx-4 mb-3" name="'+columnHeader+i+'" id="'+columnHeader+i+'" value="'+columnValues[i]+'" readonly />'); 
            modalForm.append(formGroup);
        });
    
        modalBody.append(modalForm);
        
        $('#modaleditLower').html(modalBody);
    });
        
    $('.modal-footer .btn-primary').click(function() {
        $('form[name="modalForm"]').submit();
    });

    // to delete the row in higher qualification
    function higher_id(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire('Deleted!', 'A record has been deleted', 'success')
                window.location.href='stud-edu-bg.php?higher_id='+id;
            } 
        })
    }

    // to delete the row in lower qualifiaction
    function lower_id(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire('Deleted!', 'A record has been deleted', 'success')
                window.location.href='stud-edu-bg.php?lower_id='+id;
            } 
        })
    }
</script>