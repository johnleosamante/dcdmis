<ul class="nav" id="side-menu">
		  
        <?php
	$query=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station  ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['uid']."' LIMIT 1")or die("Query data error");
	$data=mysqli_fetch_assoc($query);
	$gdata=mb_strimwidth($data['Emp_MName'],0,1);
	$_SESSION['user_information']=$data['Emp_FName'].' '.$gdata.'. '.$data['Emp_LName'];
	$_SESSION['user_discription']=$data['Job_description'];
	$_SESSION['pic']=$data['Picture'];
	$_SESSION['postby']=$data['Emp_LName'].', '.$data['Emp_FName'];
	$str=sha1("Pagadian City Division Data Management Information System");
		echo '<ul class="nav" id="side-menu">
		    <div class="panel panel-default">
                 <div class="panel-heading">';
				  if ($data['Picture']<>NULL)
				 {
                    echo  '<img src="../pcdmis/images/'.$data['Picture'].'" style="width:40px;height:40px;border-radius:5em;" align="left">';
				 }else{
					 echo  '<img src="../pcdmis/logo/user.png" style="width:40px;height:40px;border-radius:5em;" align="left">';
				 
				 }
                 echo '<label>'.$data['Emp_FName'].' '.$gdata.'. '.$data['Emp_LName'].'</label><br/>
				  <small>'.$data['Job_description'].' </small> 
				
                 </div>
                    <div class="panel-body">
				<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("settings")).'"><i class="fa fa-gear fa-fw"></i>Settings</a> || <a href="../logout"><i class="fa fa-sign-out fa-fw"></i>Logout</a>	
						
			     </div>
		    </div>
			<li class="sidebar-search">
                            <form action="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction_verifier")).'" Method="POST">
							<div class="input-group custom-search-form">
                                <input type="text" name="dts"class="form-control" placeholder="Search..." autofocus required>
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i></button>
                                </span>
                            </div></form>
                            <!-- /input-group -->
                        </li>';
		
		
		if ($_SESSION['ucode']=='Administrator')
		{
             echo '<li>
				  <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				
				</li>
				<li>
				  <a href="#"><i class="fa fa-inbox fa-fw"></i> Issuances<span class="fa arrow"></span></a>
				   <ul class="nav nav-second-level">
								<li>
									<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("division_memo")).'"> <i class="fa  fa-check fa-fw"></i>Division Memo</a>
								</li>
								<li>
									<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("division_advisory")).'"> <i class="fa  fa-check fa-fw"></i>Division Advisory</a>
								</li>
					</ul>			
				</li>
				
				<li>
				   <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_school")).'"><i class="fa fa-home fa-fw"></i> List of Schools</a>
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
								<li>
									<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("leaves")).'"><i class="fa fa-female fa-fw"></i> On Leave</a>
								</li>
							</ul>
                                                      
                        </li>  
				
				
                <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Promotion<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("erf")).'">ERF</a>
                                </li>
                                <li>
                                    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("steps")).'">STEPS</a>
                                </li>
                            </ul>
                            
                        </li>   
                            
                        ';
		}elseif ($_SESSION['ucode']=='STAFF'){
			 echo '<li>
				   <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				
				</li>
				
                    
				
				
					';
		}	
						?>
						
					  
								
         </ul>