<h4 style="text-align:center;width:100%;">SENIOR HIGH SCHOOL LIST OF STRAND/TRACK</h4>
<style>
td,th{
	text-transform:uppercase;
}
</style>
<div class="col-lg-6">
  
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		
		<tr>
			<th width="5%" style="text-align:center;" >#</th>
			<th width="40%" style="text-align:center;" >Strand / Track</th>
		    <th width="10%"># of Learner</th>
		    <th width="10%"># of Module</th>
		    <th width="5%"></th>
																
		</tr>
												
	</thead>
	<tbody>
		<?php
		$no=0;
		echo '<tr><th colspan="5" style="text-align:center;">Grade 11 Academic Track</th></tr>';
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='11' AND Strand='ACADEMIC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;	
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}			
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">'.number_format($totLearner,2).'</td>
		    <td style="text-align:center;">'.number_format($totModule,2).'</td>
		     <td style="text-align:center;"> <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view-school")).'"><i class="fa   fa-desktop  fa"></i></a></td>													
		</tr>';
		}
		
		
		$no=0;
		echo '<tr><th colspan="5" style="text-align:center;">Grade 11 TechVoc Track</th></tr>';
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='11' AND Strand='TECHVOC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}			
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">'.$totLearner.'</td>
		    <td style="text-align:center;">'.$totModule.'</td>
		     <td style="text-align:center;"> <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view-school")).'"><i class="fa   fa-desktop  fa"></i></a></td>													
		</tr>';
		}
		
		?>
	</tbody>
	</table>
	
	</div>
	
	
	
<!--Grade 12-->	
<div class="col-lg-6">
 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
		
		<tr>
			<th width="5%" style="text-align:center;" >#</th>
			<th width="40%" style="text-align:center;" >Strand / Track</th>
		    <th width="10%"># of Learner</th>
		    <th width="10%"># of Module</th>
		    <th width="5%"></th>
																
		</tr>
												
	</thead>
	<tbody>
		<?php
		$no=0;
		echo '<tr><th colspan="5" style="text-align:center;">Grade 12 Academic Track</th></tr>';
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='12' AND Strand='ACADEMIC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;	
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">'.$totLearner.'</td>
		    <td style="text-align:center;">'.$totModule.'</td>
		     <td style="text-align:center;"> <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view-school")).'"><i class="fa   fa-desktop  fa"></i></a></td>													
		</tr>';
		}
		
		
		$no=0;
		echo '<tr><th colspan="5" style="text-align:center;">Grade 12 TechVoc Track</th></tr>';
		$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Grade='12' AND Strand='TECHVOC' ORDER BY Description Asc");
		while($row=mysqli_fetch_array($result))
		{
			$no++;	
			$totLearner=$totModule=0;
			$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$row['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.GradeLevel='".$row['Grade']."'");
				while($datarow=mysqli_fetch_array($mydatabyschool))
					{
						$totLearner=$totLearner+$datarow['No_of_learner'];
						$totModule=$totModule+$datarow['No_of_copies'];
					}			
			echo '<tr>
			<td style="text-align:center;" >'.$no.'</td>
			<td>'.$row['Description'].'</td>
		    <td style="text-align:center;">'.$totLearner.'</td>
		    <td style="text-align:center;">'.$totModule.'</td>
		     <td style="text-align:center;"> <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SpCode'])).'&v='.urlencode(base64_encode("view-school")).'"><i class="fa   fa-desktop  fa"></i></a></td>													
		</tr>';
		}
		
		?>
	</tbody>
	</table>
	
	</div>