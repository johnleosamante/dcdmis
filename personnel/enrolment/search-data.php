 <?php
 if (isset($_POST['searchdata']))
 {
	 
	 $lrn=$_POST['lrn'];
	 $lrn=str_replace(" ","",$lrn);
	 $_SESSION['current_lrn']=$lrn;
	 echo '<script>
				{
					window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")).'";
				}
		</script>';
	
	 
 }
 ?>
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

                <li role="presentation" class="active">
                    <a aria-controls="step2" role="tab" title="Search Learner"  href="" style="cursor:pointer;"
                         >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                    </a>
                </li>
                <li role="presentation" class="disabled">
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
											</li>                      
										</ul><hr/>
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
				  <table  class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th>LRN</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th >Middle Name</th>
						<th width="7%"></th>
					</tr>
					</thead>
				<tbody>					
					<?php
						
							$recstudent=mysqli_query($con,"SELECT * FROM tbl_student WHERE tbl_student.lrn = '". $_SESSION['current_lrn']."' ORDER BY Lname Asc")or die ("Student Table not found!");
						//Display Information from Server to Client
							while($row=mysqli_fetch_array($recstudent))
								{
									echo '<tr>
												<td style="padding:4px;margin:4px;">'.$row['lrn'].'</a></td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['Lname'].'</td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['FName'].'</td>
												<td style="padding:4px;margin:4px;text-transform:uppercase;">'.$row['MName'].'</td>
												<td style="padding:4px;margin:4px;text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("education_history")).'">VIEW</a></td>
										</tr>';
								}
							if (mysqli_num_rows($recstudent)==0)	{
									echo '<b>Record not found!! <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("data_entry")).'">Create Record</a></b>';
								}
						?>
						</tbody>
				</table>
				</label>				
            </div>
			
			</div>
				
      

        
  
	</div>