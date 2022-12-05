<style>
th,td{
	text-transform:uppercase;
}
</style>
<?php

$result=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code = '".$_GET['code']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
$_SESSION['CurrentDistCode']=$_GET['code'];
echo '<h2>'.$row['District_Name'].' SCHOOL ICT MONTHLY REPORT</h2>';
?>

<div class="row">
<div class="col-lg-9">
	<table width="100%" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align:center;">#</th>
				<th>Name of School</th>
				<th style="text-align:center;">School In-charge</th>
				<th style="text-align:center;">Contact #</th>
				<th style="text-align:center;">No of Batches</th>
										
			</tr>
		</thead>
		<tbody>
		<?php
		$no=0;
		$districtdata=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_school.Incharg_ID INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code WHERE tbl_school.District_code='".$_GET['code']."' ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
		while ($rowdist=mysqli_fetch_array($districtdata))
		 {
			$no++;
			$batches=mysqli_query($con,"SELECT * FROM tbl_batches WHERE SchoolID='".$rowdist['SchoolID']."'");
		echo '<tr>
				<td>'.$no.'</td>
				<td>'.$rowdist['SchoolName'].'</td>
				<td>'.$rowdist['Emp_LName'].', '.$rowdist['Emp_FName'].'</td>
				<td>'.$rowdist['Emp_Cell_No'].'</td>
				<td style="text-align:center;">'.mysqli_num_rows($batches).'</td>
				<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($rowdist['SchoolID'])).'&v='.urlencode(base64_encode("dcppackage")).'"><i class="fa  fa-desktop  fa"></i></a></td>
			</tr>';
		 }
		?>	
		</tbody>
	</table>
<a href="./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=aWN0X2Zvcm0%3D" class="btn btn-secondary" style="float:right;">Back</a>	
</div>
 <div class="col-lg-3">
 
				<div class="col-lg-12 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">-</div>
                                    <div>DCP INVENTORY MONTHLY</div>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dcpinventory")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-12 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">-</div>
                                    <div>DCP UTILIZATION MONTHLY</div>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dpcutilization")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
       </div>				
  </div>				
				