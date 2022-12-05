
<style>
th{
   text-align:center;
}
</style>

              <table>
								  <?php
								  $result=mysqli_query($con,"SELECT * FROM psipop INNER JOIN tbl_employee ON psipop.TIN=tbl_employee.Emp_TIN INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_SESSION['EmpID']."'");
								  $row=mysqli_fetch_assoc($result);
									echo '
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> <label>TAX INDENTIFITION NUMBER:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['TIN'].'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> <label>ITEM NUMBER:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Item_Number'].'" class="form-control" disabled></td></tr>
									     <tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>  <label>POSITION:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Job_description'].'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>SALARY GRADE:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Salary_Grade'].'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>AUTORIZED SALARY:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.number_format($row['Autorized'],2).'" class="form-control" disabled> </td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>ACTUAL SALARY: </label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.number_format($row['Actual'],2).'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>STEP:</label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Step'].'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>DATE OF ORIGINAL APPOINTMENT: </label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Emp_DOA'].'" class="form-control" disabled></td></tr>
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i>   <label>DATE LAST PROMOTION: </label></td><td style="padding:4px;margin:4px;width:40%;"><input type="text" value="'.$row['Date_promoted'].'" class="form-control" disabled></td></tr>';
									?>
					</table>
			   
        