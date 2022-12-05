<?php
$_SESSION['Access']=$_GET['Access'];
$_SESSION['SubCode']=$_GET['SubCode'];
$_SESSION['Grade']=$_GET['GL'];
$record=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."'  AND Grade_Level='".$_GET['GL']."' AND ModuleCode='".$_SESSION['Access']."'");
$row=mysqli_fetch_assoc($record);
$_SESSION['Activity_Code']=$row['QCode'];

						

$download=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE Quarter='".$_SESSION['Quarter']."' AND SubCode='".$_SESSION['SubCode']."' AND  Grade_Level = '".$_SESSION['Grade']."' AND ModuleCode='".$_GET['Access']."' LIMIT 1");
	$rowdown=mysqli_fetch_assoc( $download);							

echo '<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div><div class="col-lg-8">';
		 $myimage=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE tbl_list_of_module_activity.SubCode='".$_SESSION['SubCode']."' AND tbl_list_of_module_activity.ModuleCode ='".$_GET['Access']."' AND Grade_Level='".$_SESSION['Grade']."'  AND Quarter='".$_SESSION['Quarter']."' LIMIT 1");
			$rowimage=mysqli_fetch_assoc($myimage);
			  echo '<iframe src="../../pcdmis/reading_materials/'.$rowimage['Module_location'].'" frameborder="0" style="width:100%;height:700px;"></iframe>';
							
echo '</div>

<div class="col-lg-4">
<div class="panel panel-default">
<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("available_module")).'" style="float:right;" class="btn btn-secondary">Back</a>
		
        <div class="panel-heading">
			Module Activity 
         </div>
																
			<div class="panel-body" style="overflow-x:auto;">
			  <table width="100%" class="table table-striped table-bordered table-hover">
					 <thead>
						 <tr>
							<th>#</th>
							<th>Type of Activity</th>
							<th></th>
						</tr>
					 </thead>
					  <tbody>';
									  
						  $no=0;
							 $Activity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND Grade_Level='".$_SESSION['Grade']."' AND ModuleCode='".$_GET['Access']."'");
							  while ($rowactivity=mysqli_fetch_array($Activity))
							  {
							   $no++;
								 echo '<tr>
									<td>'.$no.'</td>
									<td>'.$rowactivity['Type_of_activity'].' ('.$rowactivity['Name_of_activity'].')</td>
									<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($rowactivity['QCode'])).'&QNo='.urlencode(base64_encode('1')).'&ItemNo='.urlencode(base64_encode($rowactivity['ItemNo'])).'&Type='.urlencode(base64_encode($rowactivity['Name_of_activity'])).'&Name='.urlencode(base64_encode($rowactivity['Type_of_activity'])).'&v='.urlencode(base64_encode("activity_question")).'">VIEW</a></td>
									</tr>';
							  }
									 
				  echo '</tbody>
		 </table>	
	</div>
</div>
</div>';
?>
