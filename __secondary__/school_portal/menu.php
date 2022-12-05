	
		<?php
		$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station  ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['uid']."' LIMIT 1")or die("Query data error");
		$row=mysqli_fetch_assoc($result);
		$gdata=mb_strimwidth($row['Emp_MName'],0,1);
		$_SESSION['SN']=$row['Abraviate'];
		
			
		$str=sha1("Pagadian City Division Data Management Information System");
		echo '<ul class="nav" id="side-menu">
		    <div class="panel panel-default">
                 <div class="panel-heading">';
				 if ($row['Picture']<>NULL)
				 {
                  echo  '<img src="../pcdmis/images/'.$row['Picture'].'" style="width:40px;height:40px;border-radius:5em;" align="left">';
			
				 }else{
					 echo  '<img src="../pcdmis/images/user.png" style="width:40px;height:40px;border-radius:5em;" align="left">';
				 
				 }
				
                 echo '<label>'.$row['Emp_FName'].' '.$gdata.'. '.$row['Emp_LName'].'</label><br/>
				  <small>'.$row['Job_description'].' </small> (
				  <small>'.$row['Abraviate'].'</small>)
                 </div>
                    <div class="panel-body">
					<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("settings")).'"><i class="fa fa-gear fa-fw"></i>Settings</a> || <a href="../logout"><i class="fa fa-sign-out fa-fw"></i>Logout</a>	
					
			     </div>
		    </div>';
                
		
	
              echo '<li>
				   <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
                    <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> List of Personnel<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li>
									<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("personnel")).'"><i class="fa fa-user fa-fw"></i> Active</a>
								</li>
								<li>
									<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("retirable")).'"><i class="fa fa-male fa-fw"></i> Retirable</a>
								</li>
								
								
							</ul>
                                                      
                        </li>  
				 <li>
						   <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dtr")).'"><i class="fa fa-calendar fa-fw"></i> Daily Time Record</a>
							
						</li>
				
						<li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Promotion<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("erf")).'"><i class="fa fa-car  fa-fw"> </i> ERF</a>
                                </li>
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("steps")).'"><i class="fa fa-sign-in   fa-fw"> </i> STEPS</a>
                                </li>
                            </ul>
                            
                        </li>
						
						<li>
                            <a href="#"><i class="fa fa-print  fa-fw"></i> School Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("lrmds")).'"> <i class="fa fa-book fa-fw"></i> LRMDS REPORT</a>
                                </li>
								<li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("textbook")).'"> <i class="fa fa-book fa-fw"></i> TEXTBOOK REPORT</a>
                                </li>
								<li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("psdsreport")).'"> <i class="fa fa-users fa-fw"></i> PSDS REPORT</a>
                                </li>
								<li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("ictreport")).'"> <i class="fa fa-users fa-fw"></i> ICT CORNER</a>
                                </li>
                            </ul>
                            
                        </li>
						
				
				 <li>
					<a href="#"><i class="fa fa-user  fa-fw"></i> List of Learner<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">';
                            if ($_SESSION['Category']=='Secondary')
							{
						  echo '<li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Junior")).'"> <i class="fa fa-female fa-fw"></i> Junior High</a>
                                </li>
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Senior")).'"><i class="fa fa-male  fa-fw"></i> Senior High</a>
                                </li>';
								
							}elseif ($_SESSION['Category']=='Elementary'){
								echo '<li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Elementary")).'"> <i class="fa fa-users fa-fw"></i> Elementary Learners</a>
                                </li>';
							}

								
                          echo '</ul>
						          <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Section")).'"><i class="fa  fa-book fa-fw"></i> List of Section</a>
                                </li>
				    
				</li>
				
				';
				?>
													
         </ul>