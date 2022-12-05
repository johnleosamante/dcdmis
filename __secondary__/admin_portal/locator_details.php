<?php
$result=mysqli_query($con,"SELECT * FROM tbl_locator_passslip WHERE LocatorNo='".$_GET['MemoNo']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                     					
				      <h2>LOCATOR/PASS SLIP DETAILS</h2>
				 
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="" Method="POST" enctype="multipart/form-data">
						        <div class="form-group" style="font-weight: bold;">
								<?php
								    if ($row['Category']=='Official')
									{
								      echo '<label class="radio-inline" style="margin-left:50px">
                                            <input type="radio" name="category" id="optionsRadiosInline1" value="Official" checked>Official
                                        </label>
                                         <label class="radio-inline" style="margin-left:150px">
                                                <input type="radio" name="category" id="optionsRadiosInline2" value="Personal">Personal
                                         </label>';
										
									}else{
                                       echo '<label class="radio-inline" style="margin-left:50px">
                                            <input type="radio" name="category" id="optionsRadiosInline1" value="Official">Official
                                        </label>
                                         <label class="radio-inline" style="margin-left:150px">
                                                <input type="radio" name="category" id="optionsRadiosInline2" value="Personal" checked>Personal
                                         </label>';
									}
                                    ?>       
                                 </div>
						   <label>Purpose / Distination:</label>
						   <textarea name="purpose" class="form-control" rows="3"></textarea>
						    <label>Time to leave:</label>
							<input type="time" name="timeleaving" class="form-control">
							<label>Time to return:</label>
							<input type="time" name="timereturn" class="form-control">
							<label>Section:</label>
							<select  class="form-control" onchange="viewdata(this.value)">
								<option value="">--select--</option>
								<?php
								$sig=mysqli_query($con,"SELECT * FROM tbl_office WHERE Office_Name <>'SCHOOL' ORDER BY Office_Name Asc");
								while($rowsig=mysqli_fetch_array($sig))
								{
									echo '<option value="'.$rowsig['Office_Name'].'">'.$rowsig['Office_Name'].'</option>';
								}
								?>
							</select>
							<div id="signate"></div>
							<hr/>
							<input type="submit" name="savelocator" class="btn btn-primary">
							
							
						   </form>
                          
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
           
	