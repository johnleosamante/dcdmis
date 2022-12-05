
 		 <div class="wizard" style="margin-bottom: 50px;">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" >
                    <a aria-controls="step1" role="tab" title="Select type" href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_data")); ?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="">
                    <a aria-controls="step2" role="tab" title="Search Learner"  href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")); ?>" style="cursor:pointer;"
                         >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                    </a>
                </li>
                <li role="presentation" class="active">
                    <a   aria-controls="complete" role="tab" title="Educational History" href=""
                                                 >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="disabled">
                    <a   aria-controls="step3" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
           
    
            <div class="row">
            <div class="col-lg-4">
               			
					  <div class="panel panel-default">
                    <div class="panel-heading">Enrollment for School Year <?php echo $_SESSION['sy'];?></div>
					
                    <div class="list-group">
                                <div class="list-group-item">
										<ul class="list-unstyled">
											<li>
												Step 1: Search Learner
											</li><hr/>
											<li>
												 Step 2: Select Student to Enroll
											</li><hr/>
											<li>
												 Step 3: View Learner Education History
											</li>  											
										</ul>
										<hr/>
										<form action="" Method="POST" enctype="multipart/form-data">
										
                                    <label class="control-label required" for="search_form_lrn">LEARNER REFERENCE NUMBER:</label>
                                    <div class="form-group " >
                                     <input type="text" name="lrn" required class="form-control" value="<?php echo  $_SESSION['current_lrn']; ?>" ><hr/>
                                       <span class="input-group-btn"><input type="submit" name="searchdata" class="btn btn-primary" value="Search"></span>
									   </form>
									</div>
                                </div>
                               </div>
					
               
                </div>
					
						 
                    </div>
								
								
								
								
				 <div class="col-lg-8">
				 <?php
				 $recstudent=mysqli_query($con,"SELECT * FROM tbl_student WHERE tbl_student.lrn = '". $_SESSION['current_lrn']."' ORDER BY Lname Asc")or die ("Student Table not found!");
				$row1=mysqli_fetch_array($recstudent);	
				 echo '<img src="'.$row1['Picture'].'" style="width:120px;height:120px;border-radius:50%;float:right;">
				 <label style="padding:2px;margin:2px;">Leaner Name:</label><label>'.$row1['Lname'].', '.$row1['FName'].' '.$row1['MName'].'</label><br/>';
				 if ($_SESSION['Grade_Level']=='Kinder')
				 {
				 echo '<label style="padding:2px;margin:2px;text-transform:uppercase;">Grade Level:</label><label>'.$_SESSION['Grade_Level'].'</label><br/>';
				 }else{
				 echo '<label style="padding:2px;margin:2px;text-transform:uppercase;">Grade Level:</label><label>GRADE '.$_SESSION['Grade_Level'].'</label><br/>';
				 }
				 echo '<label style="padding:2px;margin:2px;text-transform:uppercase;">Section:</label><label>'.$_SESSION['SecName'].'</label><br/>
				    <label style="padding:2px;margin:2px;text-transform:uppercase;">Class Adviser:</label><label>'.$_SESSION['TeacherName'].'</label><br/>
				 <br/><hr/>';
				 ?>
				 <h4>ENROLMENT HISTORY</h4>
				  <table  class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th width="5%">#</th>
						<th>School year</th>
						<th>Year level</th>
						<th >Name of school</th>
						<th >Enrolment Status</th>
						
					</tr>
					</thead>
				<tbody>					
					<?php
					if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
					{
					  if ($_SESSION['Sem']=='First Semester')
					  {
						$myhistory=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_registration ON first_semester.lrn = tbl_registration.lrn INNER JOIN tbl_school ON first_semester.SchoolID = tbl_school.SchoolID  WHERE first_semester.lrn = '". $_SESSION['current_lrn']."' ORDER BY first_semester.school_year Asc");
				  
					  }elseif ($_SESSION['Sem']=='Second Semester')
					  {
						  $myhistory=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_registration ON second_semester.lrn = tbl_registration.lrn INNER JOIN tbl_school ON second_semester.SchoolID = tbl_school.SchoolID  WHERE second_semester.lrn = '". $_SESSION['current_lrn']."' ORDER BY second_semester.school_year Asc");
				  
						 }						  
					}else{
					
						$myhistory=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_registration ON tbl_learners.lrn = tbl_registration.lrn INNER JOIN tbl_school ON tbl_learners.SchoolID = tbl_school.SchoolID  WHERE tbl_learners.lrn = '".$_SESSION['current_lrn']."' ORDER BY tbl_learners.School_Year Asc");
					}
							$no=0;	
							//Display Information from Server to Client
							while($row=mysqli_fetch_array($myhistory))
								{
									$no++;
									echo '<tr>
												<td style="padding:4px;margin:4px;">'.$no.'</a></td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['school_year'].'</td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['Grade'].'</td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['SchoolName'].'</td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['Level_status'].'</td>
												
										</tr>';
								}
							if (mysqli_num_rows($recstudent)==0)	{
									echo '<b>Record not found!! <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("data_entry")).'">Create Record</a></b>';
								}
						?>
						</tbody>
				</table>
				<?php
				  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("enrolment")).'" class="btn btn-success" style="float:right;">Continue...</a>';			
				?>
		   </div>
			
			</div>
				
      

        
  
	</div>