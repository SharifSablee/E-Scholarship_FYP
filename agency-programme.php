<?php
require('db.php');
require('header-agency.php');


?>

welcome <?php echo $_SESSION['id']; ?>

<div class="container">
<h2>Add Program</h2>
<form action="" method="post" enctype="">
 
 
<div class="row">
<div style="float: right;"><a href='course.php' class="btn btn-primary">Add New </a></div>
<div class="col-sm-4">
<div class="form-group"><level>Name</level>
<input type="text" name="course_name" value="" class="form-control">
</div>
</div>
</div>
<div class="row">
 
<div class="col-sm-4">
 
<div class="form-group">
<label>Add Subject Required</label>
<table class="table table-bordered" id="dynamic_field"> 
<tr> 
<td><input type="text" list="datalist1" name="subject[]" placeholder="subject" value="" class="form-control name_list" />
<datalist id="datalist1">
<option>Please select subject</option>
                       
                            <option value=""></option>
                       

</datalist>
</td> 
<td><input type="text" list="datalist2" name="grade[]" value="" placeholder="grade" class="form-control name_list" />
<datalist id="datalist2">
<option>Please select required grade</option>
                        
                            <option value=""></option>
                       

</datalist>
</td>
 
<td><button type="button" name="add" id="add" class="btn btn-success"><i class=" fa fa-plus-square"></i></button></td> 

<td> <button type="button" name="remove" id="" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td>

</tr>
 
 

<!-- NEW COURSE -->
<tr> 
<td><input type="text" list="datalist1" name="subject[]" placeholder="subject" value="" class="form-control name_list" />
<datalist id="datalist1">
<option>Please select subject</option>
                        
                            <option value=""></option>
                     

</datalist>
</td> 
<td><input type="text" list="datalist2" name="grade[]" value="" placeholder="grade" class="form-control name_list" />
<datalist id="datalist2">
<option>Please select required grade</option>
                        
                            <option value=""></option>
                       

</datalist>
</td>
 
<td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
 
 
</tr>
 

 
</table>
 
</div>
</div>
 
</div>
 

<!-- Save button div starts -->
<button type="submit" id='submit' name="submit" class="btn btn-primary" value="Save">Update</button>
 

<button type="submit" id='submit' name="submit" class="btn btn-primary" value="Save">Save</button>

</form>
<hr/>
<table class="table">
<thead>
<tr>
<th>Course No</th>
<th>Name</th>
<th>Action</th>
 
</tr>
</thead>
<tbody>

<tr>
<td></td>
<td> </td>
<td> <a href='course.php?cid='>Edit </a></td>
 
</tr>
 

 
</tbody>
</table>
 
</div>
