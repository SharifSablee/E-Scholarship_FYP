<?php
require_once('db.php');
include('header-stud.php');
include('stud-profile-process.php');

$id = $_SESSION['id'];
$data = "SELECT * FROM user_accounts WHERE id = $id";
$run_data = mysqli_query($con, $data);
if ($run_data) {

    $fetch_info = mysqli_fetch_assoc($run_data);
    $name = $fetch_info['name'];
    $email = $fetch_info['email'];
    $phonenumber = $fetch_info['phone_number'];
}

$profile = "SELECT * FROM stud_profiles WHERE user_id = $id";
$run_profile = mysqli_query($con, $profile);
if ($run_profile) {
    $fetch_profile = mysqli_fetch_assoc($run_profile);
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
                $profile = "SELECT * FROM stud_profiles WHERE user_id = $id";
                $run_profile = mysqli_query($con, $profile);
                if (mysqli_num_rows($run_profile) > 0) {
                    $fetch_pict = mysqli_fetch_assoc($run_profile);
                        if($fetch_pict['profile_picture'] == "") {
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
                <a data-toggle="tab" href="#myprofile" class="list-group-item list-group-item-action active">
                    My Profile
                </a>
                <a data-toggle="tab" href="#personalinfo" class="list-group-item list-group-item-action">
                    Personal Information
                </a>
                <a data-toggle="tab" href="#educationalbg" class="list-group-item list-group-item-action">
                    Educational Background
                </a>
                <a data-toggle="tab" href="#documents" class="list-group-item list-group-item-action">
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
                            <label for="name"><h4>Name</h4></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name ?>">
                        </div>
                                                       
                        <!-- email -->
                        <div class="form-group col-lg-12">
                            <label for="email"><h4>Email</h4></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email ?>">
                        </div>

                        <!-- phone number -->
                        <div class="form-group col-lg-12">
                            <label for="phonenumber"><h4>Phone Number</h4></label>
                            <input type="number" class="form-control" name="phonenumber" id="phonenumber" placeholder="Phone Number" value="<?php echo $phonenumber?>">
                        </div>
                      </div>
                      
                      <!-- button -->
                      <div class="form-group">
                           <div class="col-lg-12 text-right mt-3">
                              	<button class="btn btn-lg btn-success" type="submit" name="save-myprofile"><i class="fa fa-check whiteicon"></i> Save</button>
                               	<button class="btn btn-lg" type="reset"><i class="fa fa-redo-alt whiteicon"></i> Reset</button>
                            </div>
                      </div>
              	</form>
              <hr class="mt-4 mb-5">
             </div>
             
             <!-- for personal information tab -->
             <div class="tab-pane px-5" id="personalinfo">
                <hr class="mt-0 mb-4">
                    <form class="form px-5 pt-0" action="" method="post" id="registrationForm">
                        <div class="row mb-2">

                            <!-- date of birth -->
                            <div class="form-group col-lg-6">
                                <label for="dob"><h4>Date of Birth</h4></label>
                                    <?php 
                                        if ($fetch_profile['date_of_birth'] == "0000-00-00") {
                                            echo "<input class='form-control' id='dob' name='dob' placeholder='Date of Birth' type='text' autocomplete='off' />";
                                        } else {
                                            echo "<input class='form-control' id='dob' name='dob' placeholder='Date of Birth' type='text' value='".date('d M Y', strtotime($fetch_profile['date_of_birth']))."' />";
                                        }
                                    ?> 
                            </div>

                            <!-- place of birth -->
                            <div class="form-group col-lg-6">
                                <label for="placebirth"><h4>Place of Birth</h4></label>
                                <?php 
                                    if ($fetch_profile['birth_place'] == "") {
                                        echo "<input type='text' class='form-control' name='placebirth' id='placebirth' placeholder='Place of Birth'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='placebirth' id='placebirth' placeholder='Place of Birth' value='".$fetch_profile['birth_place']."' />";
                                    }
                                ?> 
                            </div>

                            <!-- ic number -->
                            <div class="form-group col-lg-12">
                                <label for="icnumber"><h4>IC Number</h4></label>
                                <?php 
                                    if ($fetch_profile['ic_number'] == "") {
                                        echo "<input type='number' class='form-control' name='icnumber' id='icnumber' placeholder='example: 01123456'>";
                                    } else {
                                        echo "<input type='number' class='form-control' name='icnumber' id='icnumber' placeholder='example: 01123456' value='".$fetch_profile['ic_number']."' />";
                                    }
                                ?>
                            </div>

                            <!-- ic colour -->
                            <div class="form-group col-lg-12">
                                <label for="colour"><h4>Colour</h4></label>
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
                                <label for="per_address"><h4>Permanent Address</h4></label>
                                <?php 
                                    if ($fetch_profile['address'] == "") {
                                        echo "<textarea method='post' name='per_address' id='per_address' rows='3' class='form-control' placeholder='Permanent Address'></textarea>";
                                    } else {
                                        echo "<textarea name='per_address' id='per_address' rows='3' class='form-control' placeholder='Permanent Address'>".$fetch_profile['address']."</textarea>";
                                    }
                                ?>
                            </div>

                            <!-- post code -->
                            <div class="form-group col-lg-6">
                                <label for="per_postcode"><h4>Post Code</h4></label>
                                <?php 
                                    if (empty($fetch_profile['postcode'])) {
                                        echo "<input type='text' class='form-control' name='per_postcode' id='per_postcode' placeholder='Post Code'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='per_postcode' id='per_postcode' placeholder='Post Code' value='".$fetch_profile['postcode']."' />";
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
                                <label for="pos_address"><h4>Postal Address</h4></label>
                                <?php 
                                    if ($fetch_profile['postal_address'] == "") {
                                        echo "<textarea method='post' name='pos_address' id='pos_address' rows='3' class='form-control' placeholder='Postal Address'></textarea>";
                                    } else {
                                        echo "<textarea name='pos_address' id='pos_address' rows='3' class='form-control' placeholder='Postal Address'>".$fetch_profile['postal_address']."</textarea>";
                                    }
                                ?>
                            </div>

                            <!-- post code -->
                            <div class="form-group col-lg-6" id="postal_postcode">
                                <label for="pos_postcode"><h4>Post Code</h4></label>
                                <?php 
                                    if (empty($fetch_profile['postal_postcode'])) {
                                        echo "<input type='text' class='form-control' name='pos_postcode' id='pos_postcode' placeholder='Post Code'>";
                                    } else {
                                        echo "<input type='text' class='form-control' name='pos_postcode' id='pos_postcode' placeholder='Post Code' value='".$fetch_profile['postal_postcode']."' />";
                                    }
                                ?>
                            </div>

                        </div>
                        
                        <!-- button -->
                        <div class="form-group">
                            <div class="col-lg-12 text-right mt-3">
                                    <button class="btn btn-lg btn-success" type="submit" name="save-personalinfo"><i class="fa fa-check whiteicon"></i> Save</button>
                                    <button class="btn btn-lg" type="reset"><i class="fa fa-redo-alt whiteicon"></i> Reset</button>
                                </div>
                        </div>
                    </form>
                <hr class="mt-4 mb-5">
             </div>
             
             <!-- for educational background tab-->
             <div class="tab-pane px-5" id="educationalbg">	
                <hr class="mt-0 mb-4">
                    <div class="row mb-2 pl-2 pt-0">
                        
                        <div class="form-group">
                            <label class="col-lg-10"><h4><i class="fas fa-graduation-cap pr-2"></i>Higher Education Qualifications</h4></label>
                            <button type="button" class="btn btn-outline-success col-lg-1" name="add-qualifications" data-bs-toggle="modal" data-bs-target="#highereducation">Add</button>

                            <!-- Modal -->
                            <div class="modal fade" id="highereducation" data-bs-backdrop="static">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Higher Education Qualifications</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="" class="form text-left" method="post">
                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- qualifications -->
                                        <label for="qualification" class="col-lg-5"><h4>Qualifications:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='qualifications' name='qualifications' onchange='yesnoCheck(this)'>
                                            <option value='' disabled selected hidden>Select Qualifications</option>
                                            <option value="advdiploma">Advanced Diploma</option>
                                            <option value="diploma">Diploma</option>
                                            <option value="hnd">Higher National Diploma (HND)</option>
                                            <option value="hntec">Higher National Technical Education Certificate (HNTec)</option>
                                            <option value="ntec">National Technical Education Certificate (NTec)</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row mycontainer">
                                        <div id="ifYes" style="display: none;">
                                            <label for="others" class="col-lg-5 mycontainer"></label>
                                            <input type='text' class='form-control col-lg-7 mycontainer' name='others' id='others' placeholder='Please State'>
                                        </div>
                                    </div>
                                </div>
                                        
                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- courses -->
                                        <label for="course" class="col-lg-5"><h4>Course:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='course' name='course'>
                                            <option value='' disabled selected hidden>Select Courses</option>
                                            <option value="">Agrotechnology</option>
                                            <option value="">Aircraft Maintenance Engineering (airframe and Engine)</option>
                                            <option value="">Aircraft Maintenance Engineering (avionics)</option>
                                            <option value="">Aquaculture</option>
                                            <option value="">Architecture</option>
                                            <option value="">Assistant Nurse (general Nursing)</option>
                                            <option value="">Automobile Technology</option>
                                            <option value="">Automotive Technician</option>
                                            <option value="">Blasting and Painting (oil and Gas Industry)</option>
                                            <option value="">Building Craft</option>
                                            <option value="">Building Services Engineering</option>
                                            <option value="">Business Accounting & Finance</option>
                                            <option value="">Business Studies</option>
                                            <option value="">Business Studies (entrepreneurship)</option>
                                            <option value="">Business Studies (human Resource Management)</option>
                                            <option value="">Business Studies (marketing)</option>
                                            <option value="">Business and Administration</option>
                                            <option value="">Business and Finance</option>
                                            <option value="">Chemical Engineering</option>
                                            <option value="">Civil Engineering</option>
                                            <option value="">Computer Networking</option>
                                            <option value="">Construction and Draughting (dual Tvet)</option>
                                            <option value="">Control and Automation Engineering (hengyi)</option>
                                            <option value="">Crop and Livestock Production</option>
                                            <option value="">Culinary Operations</option>
                                            <option value="">Data Analytics</option>
                                            <option value="">Deck Rating</option>
                                            <option value="">Dental Assisting</option>
                                            <option value="">Digital Media</option>
                                            <option value="">Electrical Engineering</option>
                                            <option value="">Electrical Technology</option>
                                            <option value="">Electrical and Electronic Engineering</option>
                                            <option value="">Electronic Engineering</option>
                                            <option value="">Electronics and Communications Engineering</option>
                                            <option value="">Electronics and Media Technology</option>
                                            <option value="">Engine Rating</option>
                                            <option value="">Food Processing</option>
                                            <option value="">Health Science (cardiovascular Technology)</option>
                                            <option value="">Health Science (dental Hygiene & Therapy)</option>
                                            <option value="">Health Science (environmental Health)</option>
                                            <option value="">Health Science (midwifery)</option>
                                            <option value="">Health Science (nursing)</option>
                                            <option value="">Health Science (paramedics)</option>
                                            <option value="">Heavy Vehicle Mechanics</option>
                                            <option value="">Hospitality Operations</option>
                                            <option value="">Industrial Equipment Maintenance</option>
                                            <option value="">Industrial Machining & Maintenance</option>
                                            <option value="">Information Systems</option>
                                            <option value="">Information Technology</option>
                                            <option value="">Information and Library Studies</option>
                                            <option value="">Instrumentation and Control Engineering</option>
                                            <option value="">Interior Design</option>
                                            <option value="">It Network</option>
                                            <option value="">Laboratory Science</option>
                                            <option value="">Library Informatics Computing</option>
                                            <option value="">Light Vehicle Mechanics</option>
                                            <option value="">Marine Engineering</option>
                                            <option value="">Markinga Nd Fitting (oil and Gas Industry)</option>
                                            <option value="">Mechanical Engineering</option>
                                            <option value="">Nautical Studies</option>
                                            <option value="">Office Administration</option>
                                            <option value="">Petroleum Engineering</option>
                                            <option value="">Pharmacy Technician</option>
                                            <option value="">Plant Engineering</option>
                                            <option value="">Professional Cookery & Services</option>
                                            <option value="">Real Estate Management and Agency</option>
                                            <option value="">Refinery Operator (hengyi)</option>
                                            <option value="">Refrigeration and Air-conditioning</option>
                                            <option value="">Rigging (oil and Gas Industry)</option>
                                            <option value="">Rooms Division Operations</option>
                                            <option value="">Scaffolding (oil and Gass Industry)</option>
                                            <option value="">Science Technology</option>
                                            <option value="">Telecommunication and System Engineering</option>
                                            <option value="">Travel and Tourism</option>
                                            <option value="">Web Development</option>
                                            <option value="">Welding</option>
                                            <option value="">Welding (oil and Gas Industry)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- result -->
                                        <label for="result" class="col-lg-5"><h4>Result:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='result' name='result'>
                                            <option value='' disabled selected hidden>Please Choose</option>
                                            <option value="">Passed</option>
                                            <option value="">Failed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- year -->
                                        <label for="year" class="col-lg-5"><h4>Year:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='year' name='year'>
                                            <option value='' disabled selected hidden>Please Choose</option>
                                            <option value="">Passed</option>
                                            <option value="">Failed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- university/institution -->
                                        <label for="institutions" class="col-lg-5"><h4>Institutions:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='institutions' name='institutions'>
                                            <option value='' disabled selected hidden>Select Institutions</option>
                                            <option value="">Institute Brunei Technical Education (ibte)</option>
                                            <option value="">Politeknik Brunei (pb)</option>
                                            <option value="">University Brunei Darussalam (ubd)</option>
                                            <option value="">University Islam Sultan Sharif Ali (unissa)</option>
                                            <option value="">University Technology Brunei (utb)</option>
                                        </select>
                                    </div>
                                </div>
                                        
                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-md btn-success" type="submit" name="save-personalinfo"><i class="fa fa-check whiteicon"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>  
    
                    </div>

                <hr class="mt-2 mb-0">

                <div class="row mt-4 mb-2 pl-2 pt-0">
                        
                        <div class="form-group">
                            <label class="col-lg-10"><h4><i class="fas fa-graduation-cap pr-2"></i>Lower Education Qualifications</h4></label>
                            <button type="button" class="btn btn-outline-success col-lg-1" name="add-qualifications" data-bs-toggle="modal" data-bs-target="#lowereducation">Add</button>

                            <!-- Modal -->
                            <div class="modal fade" id="lowereducation" data-bs-backdrop="static">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Lower Education Qualifications</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="" class="form text-left" method="post">
                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- qualifications -->
                                        <label for="qualification" class="col-lg-5"><h4>Qualifications:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='qualifications' name='qualifications'>
                                            <option value='' disabled selected hidden>Select Qualifications</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                        
                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- courses -->
                                        <label for="course" class="col-lg-5"><h4>Course:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='course' name='course'>
                                            <option value='' disabled selected hidden>Select Courses</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- result -->
                                        <label for="result" class="col-lg-5"><h4>Result:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='result' name='result'>
                                            <option value='' disabled selected hidden>Please Choose</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- year -->
                                        <label for="result" class="col-lg-5"><h4>Result:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='result' name='result'>
                                            <option value='' disabled selected hidden>Please Choose</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group d-inline-flex">
                                        <!-- university/institution -->
                                        <label for="institutions" class="col-lg-5"><h4>Institutions:</h4></label>
                                        <select class='form-select form-control col-lg-7' id='institutions' name='institutions'>
                                            <option value='' disabled selected hidden>Select Institutions</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                        
                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-md btn-success" type="submit" name="save-personalinfo"><i class="fa fa-check whiteicon"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>  
    
                    </div>
                <hr class="mt-2 mb-0">
                
              </div>

             <!-- for documents tab-->
             <div class="tab-pane px-5" id="documents">	
                <hr class="mt-0 mb-4">
                    <form class="form px-5 pt-0" action="" method="post" id="registrationForm">
                        <div class="row mb-2">

                            <!-- BJCE / lower cert -->
                            <div class="form-group col-lg-12">
                                <label for="lower-cert"><h4>Lower Certificate of Education or it's equivalent</h4></label>
                                <input type="file" class="form-control" name="lower-cert" id="lower-cert">
                            </div>

                        </div>

                        <div class="row mb-2">
                            <!-- GCE Olevel -->
                            <div class="form-group col-lg-12">
                                <label for="olevel"><h4>GCE 'O' Level or it's equivalent</h4></label>
                                <input type="file" class="form-control" name="olevel" id="olevel">
                            </div>

                        </div>
                        
                        <div class="row mb-2">
                            <!-- GCE Alevel  -->
                            <div class="form-group col-lg-12">
                                <label for="alevel"><h4>GCE 'A' Level or it's equivalent</h4></label>
                                <input type="file" class="form-control" name="alevel" id="alevel">
                            </div>

                        </div>

                        <div class="row mb-2">

                            <!--  first degree / HND  -->
                            <div class="form-group col-lg-12">
                                <label for="hnd"><h4>First Degree / HND or it's equivalent</h4></label>
                                <input type="file" class="form-control" name="hnd" id="hnd">
                            </div>
                        </div>
                        
                        <!-- button -->
                        <div class="form-group">
                            <div class="col-lg-12 text-right mt-3">
                                    <button class="btn btn-lg btn-success" type="submit"><i class="fa fa-check whiteicon"></i> Save</button>
                                    <button class="btn btn-lg" type="reset"><i class="fa fa-redo-alt whiteicon"></i> Reset</button>
                                </div>
                        </div>
                    </form>
                <hr class="mt-4 mb-0">
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
                reader.onload = function(e) {
                    document.querySelector('#profileDisplay').setAttribute('src', e.target.result); 
                }
                reader.readAsDataURL(e.files[0]);

                // display the save button
                $('#save-pict').removeClass('d-none');
            }
        }
    </script>

    <!-- datepicker calendar -->
    <script>
        $(document).ready(function(){
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'd M yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);
        })
    </script>

    <!-- hide postal address if check -->
    <script>
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

    <!-- display if choose others -->
    <script>
    function yesnoCheck(that) {
        if (that.value == "others") {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
    </script>