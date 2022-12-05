
<style>
th{
   text-align:center;
}
</style>
<script>
{
   document.addEventListener('contextmenu', event => event.preventDefault());
}
   </script> 

				 
				     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" rowspan="2">#</th>
												<th width="35%" rowspan="2">TITLE OF TRAININGS</th>
												<th width="20%" colspan="2" >DATE COVERED</th>
												<th width="20%" rowspan="2">CONDUCTED BY</th>
												<th width="10%" rowspan="2">OFFICE</th>
												<th width="7%" rowspan="2"></th>
											</tr>
										<tr>
											<th>FROM</th>
											<th>TO</th>
										</tr>										
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$seminar=mysqli_query($con,"SELECT * FROM tbl_seminar_participant INNER JOIN tbl_seminar ON tbl_seminar_participant.Training_Code= tbl_seminar.Training_Code WHERE tbl_seminar_participant.Emp_ID ='".$_SESSION['EmpID']."'") or die ("error training data");
										while($row=mysqli_fetch_array($seminar))
										{
											$no++;
										echo '<tr><td style="text-align:center;">'.$no.'</td>
												<td>'.$row['Title_of_training'].'</td>
												<td>'.$row['covered_from'].'</td>
												<td>'.$row['covered_to'].'</td>
												<td>'.$row['conducted_by'].'</td>
												<td style="text-align:center;">'.$row['Office'].'</td>
												
												<td class="dropdown">
															
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="my_qautame.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#myquatame"><i class="fa  fa-user  fa-fw"></i> Quatame</a>
																</li>
																
																<li><a href="my_certificate.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#mycertificate"><i class="fa  fa-credit-card  fa-fw"></i> Certificate</a>
																</li>												
																<li><a href="../'.$row['Training_Memo'].'" target="_blank"><i class="fa  fa-credit-card  fa-fw"></i> Memo</a>
																</li>		
															</ul>
															
														
													</td></tr>';
										}
													?>
									
									</tbody>
									</table>
									
									
     
<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
   }
   
   .loginbox{
	   width:70%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					
			}
		
   </style>


<!-- Modal for Re-assign-->
    <div class="modal fade" id="myquatame" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="loginbox">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>
		
<!-- Modal for Re-assign-->
    <div class="modal fade" id="mycertificate" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="loginbox">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>
			  		