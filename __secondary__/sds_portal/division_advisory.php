
                 <div class="col-lg-10">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="" style="float:right;" class="btn btn-primary">UPLOAD ADVISORY</a>
							<h4>Issuances -> Division Advisory</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
								  <tr>
									<th width="5%" style="text-align:center;">#</th>
									<th width="10%">Date Released</th>
									<th>Title</th>
									<th width="14%">Posted by</th>
									<th width="12%"></th>
									
									</tr>
								</thead>
                                <tbody>
								<?php
								$no=0;
								$update=mysqli_query($con,"SELECT * FROM post INNER JOIN tbl_employee ON post.posted_by=tbl_employee.Emp_ID  WHERE post.Post_Type='Advisory' ORDER BY post.date_posted Desc");
							   while($rowup=mysqli_fetch_array($update))
									 {
										 $no++;
										 $noOfComment=mysqli_query($con,"SELECT * FROM reply WHERE chat_id='".$rowup['chatID']."'");
								     echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowup['date_posted'].'</td>
											<td>'.$rowup['post_Title'].'</td>
											<td>'.$rowup['Emp_FName'].' '.$rowup['Emp_LName'].'<br/>('.$rowup['post_office'].' SECTION)</td>
											<td style="text-align:center;">
												<a href="view-attachment.php?id='.urlencode(base64_encode($rowup['chatID'])).'" data-toggle="modal" data-target="#viewcomment"><i class="fa  fa-comments fa-fw"></i>('.mysqli_num_rows($noOfComment).')</a> |
												<a href=""><i class="fa  fa-download fa-fw"></i>(0)</a>
											</td>
										</tr>';
									 }
								   ?>
								
                                </tbody>
								</table>
						</div>
						
					</div>
                  </div>
                   <div class="col-lg-2">
				   <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>School Year</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						$result=mysqli_query($con,"SELECT * FROM tbl_school_year ORDER BY SYCode Asc");
						while($row=mysqli_fetch_array($result))
						{
							echo '   <div class="radio">
                                           
                                            <label>
                                               <input type="radio" name="optionsRadios" id="optionsRadios1" value="'.$row['SYCode'].'">'.$row['SchoolYear'].'
                                            </label>
									 </div>';
                                            
												  							
						}
						?>	 
						</div>
					</div>
				  </div>
				  
		
              <!-- Modal -->
	 <div class="modal fade" id="viewcomment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="width:1250px;margin-left:auto;margin-right:auto;margin-top:10px;height:450px;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			

	</div></div>
	</div>
 									