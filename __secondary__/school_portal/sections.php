<style>
	 th,td{
		text-transform:uppercase;
	}	
		
   </style>
    
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<a href="#new-section" class="btn btn-primary" data-toggle="modal" style="float:right;">Add New Section</a>
							<h3>Section's Masterlist</h3>
							<?php
							if (isset($_POST['new_section']))
							{
							$mytitle=$_POST['Section_name'];
							$mytitle=str_replace("'","\'",$mytitle);	
							mysqli_query($con,"INSERT INTO tbl_section VALUES (NULL,'".$mytitle."','".$_POST['Grade_Level']."','".$_SESSION['year']."','".$_SESSION['Category']."','".$_SESSION['school_id']."','".$_POST['rm_location']."','".$_POST['class_adviser']."')");
							if (mysqli_affected_rows($con))
							{
							$Err = "Section Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
								
							}
							}
							?>							
                        </div>
                        <!-- /.panel-heading -->
						
						
						
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="7%">#</th>
                                        <th width="10%">Grade</th>
                                        <th width="15%">Section Name</th>
                                        <th width="20%">Adviser</th>
                                        <th width="20%">Location</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  ORDER BY tbl_section.Grade Asc")or die ('Error Adding Section');
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr>
											<td style="text-align:center;">'.$no.'</td>'
											;
									if ($row['Grade']=='Kinder')
										{	
											echo '<td>'.$row['Grade'].'</td>';
										}else{
											echo '<td> Grade '.$row['Grade'].'</td>';
										}
										
									 echo '<td style="text-align:center;">'.$row['SecDesc'].'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>									
											<td>'.$row['Room_location'].'</td>									
																	
											<td>
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&SecCode='.urlencode(base64_encode($row['SecCode'])).'&v='.urlencode(base64_encode("viewlist")).'" class="btn btn-primary">VIEW</a><br/>
											
											</td>
                                        </tr>';
                                    
									}						
									?>
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            



   <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="new-section" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Add New Section</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<label>Section Code</label>
		<input type="text" class="form-control" value="<?php echo date('ydms');?>"disabled>
		
		<label>Section Name</label>
		<input type="text" name="Section_name"  class="form-control" placeholder="Enter Section Name" required>
		<label>Section Year Level</label>
		<select name="Grade_Level"  class="form-control" required>
			<option value="">--Select--</option>
			<?php
			if ( $_SESSION['Category']=='Elementary')
			{
			echo '<option value="Kinder">Kinder</option>
				
 				  <option value="1">Grade 1</option>
				  <option value="2">Grade 2</option>
				  <option value="3">Grade 3</option>
				  <option value="4">Grade 4</option>
				  <option value="5">Grade 5</option>
				  <option value="6">Grade 6</option>';
			}elseif ( $_SESSION['Category']=='Secondary')
			{
			echo '<option value="7">Grade 7</option>
				  <option value="8">Grade 8</option>
				  <option value="9">Grade 9</option>
 				  <option value="10">Grade 10</option>
				  <option value="11">Grade 11</option>
				  <option value="12">Grade 12</option>
				  ';
			}
			?>	  
				  
		</select>
		<label>Class Adviser</label>
		<select name="class_adviser"  class="form-control" required>
			<option value="">--Select--</option>
			<?php
			$adviser=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_station.Emp_Station = '".$_SESSION['school_id']."'ORDER BY tbl_employee.Emp_LName Asc");
			while($adrow=mysqli_fetch_array($adviser))
			{
				echo '<option value="'.$adrow['Emp_ID'].'">'.$adrow['Emp_LName'].','.$adrow['Emp_FName'].'</option>';
			}
			?>
		</select>
		<label>Room Location</label>
		<input type="text" name="rm_location"  class="form-control" placeholder="Enter Room / Section location" required><hr/>
		<input type="submit" name="new_section" value="Save" style="width:100%;cursor:pointer;font-size:14px;height:40px;padding:4px;margin:4px;" class="btn btn-primary">
        </form>
		</div>
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
