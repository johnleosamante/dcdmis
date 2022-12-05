	<?php
	$_SESSION['ItemNo']=$_GET['ItemNo'];
				
	//Module Information
	$mymodule=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE ModuleCode='".$_SESSION['Access']."' LIMIT 1");
	 $rowmodule=mysqli_fetch_assoc($mymodule);
	 //Activity Information
	 $result=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE QCode ='".$_GET['m']."'");
	 $row=mysqli_fetch_assoc($result);
	 $_SESSION['Type_of_activty']=$row['Type_of_activity'];
	 $_SESSION['activty']=$row['Name_of_activity'];
		  
		  
	  echo '<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div><div class="modal-header">
          <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($_SESSION['Grade'])).'&SubCode='.urlencode(base64_encode($_SESSION['SubCode'])).'&Access='.urlencode(base64_encode($_SESSION['Access'])).'&v='.urlencode(base64_encode("activity_sheets")).'" class="close" data-dismiss="modal">&times;</a>
          <h3 class="modal-title" style="text-transform:uppercase;">Module Title: '.$rowmodule['Filename'].'</h3>
		
        </div>
        <div class="modal-body">
		
		<div class="col-lg-8">';
		 
		  echo '<form action ="" method="POST" enctype="multipart/form-data">
		  <div class="alert alert-success" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;text-transform:uppercase;">';
		
		//Instruction details
		  $direction=mysqli_query($con,"SELECT * FROM tbl_activity_sheets_instruction WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' LIMIT 1");
		  $rowdirect=mysqli_fetch_assoc($direction);
		 
		 //Question Data
		 $myquestion=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$_GET['QNo']."'");
		 $rowquestion=mysqli_fetch_assoc($myquestion);	

			echo '<p style="color:red;">'.$rowdirect['Activity_Instruction'].'</p><hr/>';		
		echo '<h4>'.$_GET['QNo'].'. '.$rowquestion['Activity_question'].'</h4></div>
		 <div class="alert alert-info" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;text-transform:uppercase;">
		';
		
		
		
         $myoption=mysqli_query($con,"SELECT * FROM tbl_activity_sheets_option WHERE QNumber='".$_GET['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND Activity_code='".$_GET['m']."'");		
		  if ($row['Name_of_activity']=='MULTIPLE CHOICE')
		  {
			  $mydata=mysqli_query($con,"SELECT * FROM tbl_activity_sheets_option WHERE QNumber='".$_GET['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND Activity_code='".$_GET['m']."'");		
		     if (mysqli_num_rows($mydata)<>0)
			 {
				  while($rowoption=mysqli_fetch_array($mydata))
					{
						$queoption=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$rowoption['Activity_code']."' AND Activity_No='".$rowoption['QNumber']."'");	
						$rowopanswer=mysqli_fetch_assoc($queoption);
						if ($rowopanswer['Correct_Answer']==$rowoption['Letter'])	
						{
							 echo '<div class="radio">
								 <label>
									<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowoption['Letter'].'" required checked>'.$rowoption['QOption'].'
								 </label>
							</div>';
						}else{					
						echo '<div class="radio">
								 <label>
									<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowoption['Letter'].'" required>'.$rowoption['QOption'].'
								 </label>
							</div>';
							}
					}
					
			 }else{
			echo '<div class="form-group">
                        <div class="form-group input-group">
                            <span class="input-group-addon">A</span>
                            <input type="text" name="A" class="form-control" placeholder="Option A">
                        </div>';
						
                       echo '<div class="form-group input-group">
                            <span class="input-group-addon">B</span>
                            <input type="text" name="B" class="form-control" placeholder="Option B">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">C</span>
                            <input type="text" name="C" class="form-control" placeholder="Option C">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">D</span>
                            <input type="text" name="D" class="form-control" placeholder="Option D">
                        </div>';
						
						echo '<div class="form-group input-group">
                            <span class="input-group-addon">E</span>
                            <input type="text" name="E" class="form-control" placeholder="Option E">
                        </div>';
						
                    echo '</div><select name="Answer" class="form-control" required>
					      <option value="">--Select--</option>
					      <option value="A">A</option>
					      <option value="B">B</option>
					      <option value="C">C</option>
					      <option value="D">D</option>
					      <option value="E">E</option>
					 </select>';
			 } 
			
		  }else{
			  while($rowoption=mysqli_fetch_array($myoption))
					{
						$queoption=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$rowoption['Activity_code']."' AND Activity_No='".$rowoption['QNumber']."'");	
						$rowopanswer=mysqli_fetch_assoc($queoption);
						if ($rowopanswer['Correct_Answer']==$rowoption['QOption'])	
						{
							 echo '<div class="radio">
								 <label>
									<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowoption['QOption'].'" required checked>'.$rowoption['QOption'].'
								 </label>
							</div>';
						}else{					
						echo '<div class="radio">
								 <label>
									<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowoption['QOption'].'" required>'.$rowoption['QOption'].'
								 </label>
							</div>';
							}
				}
		  }
		
		
					
		?>
	   </form>
	  </div>
	  
	  </div>
	  </div>

	<div class="col-lg-4">
		<div class="alert alert-info" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:14px;">
		<?php
		$Number=1;
		echo '<p><b>Activity #: '.$_GET['QNo'].'  '.$row['Type_of_activity'].' ('.$row['Name_of_activity'].')</b></p><hr/>';
		while ($Number<= $_SESSION['ItemNo'])
		{
			$queop=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$Number."'");	
			$rowop=mysqli_fetch_assoc($queop);	
            if ($rowop['Correct_Answer']<>"-")
			{
			echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&ItemNo='.urlencode(base64_encode($_SESSION['ItemNo'])).'&QNo='.urlencode(base64_encode($Number)).'&m='.urlencode(base64_encode($_GET['m'])).'&v='.urlencode(base64_encode("activity_question")).'" class="btn btn-success" style="height:60px;padding:10px;margin:4px;">'.$Number.'</a>';	
			}else{				
			echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&ItemNo='.urlencode(base64_encode($_SESSION['ItemNo'])).'&QNo='.urlencode(base64_encode($Number)).'&m='.urlencode(base64_encode($_GET['m'])).'&v='.urlencode(base64_encode("activity_question")).'" class="btn btn-secondary" style="height:60px;padding:10px;margin:4px;">'.$Number.'</a>';
			}
			$Number++;
		}
		$querydata=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE QCode='".$_GET['m']."' LIMIT 1");
		$rowstatus=mysqli_fetch_assoc($querydata);
		echo '<h4 style="padding:4px;">Activity sheet is currently '.$rowstatus['Activity_status'].'</h4>';


		 ?>
				 
		</div>
	  </div>
  