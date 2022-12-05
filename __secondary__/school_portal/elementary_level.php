<a href="#newreport" class="btn btn-primary" data-toggle="modal">Add new report</a><hr/>
<div style="overflow-x:auto; width:100%;" >

<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">                        
	<thead>
		<tr>
		<th width="10%" style="text-align:center;" rowspan="2">GRADE LEVEL</th>
			<th width="10%" style="text-align:center;" rowspan="2"># OF LEARNERS</th>
			<th colspan="10" style="text-align:center;">ELEMENTARY LEARNING AREAS</th>
			<th width="10%" rowspan="2">TOTAL</th>
			<th width="7%" rowspan="2"></th>
																
		</tr>
		<tr>
			<td>English</td>
			<td>Science</td>
			<td>Math</td>
			<td>Filipino</td>
			<td>Aral. Pan.</td>
			<td>E.S.P</td>
			<td>TLE/EPP</td>
			<td>MAPEH</td>
			<td>MOTHER TONGUE</td>
			<td>PROJECT RUSH</td>
		</tr>
	</thead>
  <tbody>	
  <?php
  $total=$noOfLeaner=$totaleng=$totalscien=$totalMath=$totalFil=$subtotal=$totalRO=$totalPR=0;
  $totalAral=$totalEsp=$totaltle=$totalmusic=$totalarts=$totalpe=$totalhealth=$totalThematic=0;
														
  $mysubject=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."' ORDER BY GradeLevel Asc");
														
	while($rowsubject=mysqli_fetch_array($mysubject))
		{
			$total=	$rowsubject['English'] + $rowsubject['Science'] + $rowsubject['Math'] + $rowsubject['Filipino'] + $rowsubject['AralPan'] + $rowsubject['ESP'] + $rowsubject['TLE'] + $rowsubject['MAPEH'] + $rowsubject['Mother_tongue']+$rowsubject['Project_Rush']+$rowsubject['RO_Thematic'];
				echo '<tr>
						<td>'.$rowsubject['GradeLevel'].'</td>
						<td>'.$rowsubject['No_of_learner'].'</td>
						<td>'.$rowsubject['English'].'</td>
						<td>'.$rowsubject['Science'].'</td>
						<td>'.$rowsubject['Math'].'</td>
						<td>'.$rowsubject['Filipino'].'</td>
						<td>'.$rowsubject['AralPan'].'</td>
						<td>'.$rowsubject['ESP'].'</td>
						<td>'.$rowsubject['TLE'].'</td>
						<td>'.$rowsubject['MAPEH'].'</td>
						<td>'.$rowsubject['Mother_tongue'].'</td>
						
						<td>'.$rowsubject['Project_Rush'].'</td>
						<td>'.number_format($total,0).'</td>
						<td>
							<a href="update-lrmds.php?id='.$rowsubject['SubNo'].'&Category=Elementary" data-target="#updatereport" data-toggle="modal" title="Edit" class="btn btn-primary" style="margin:4px;padding:4px;"><i class="fa fa-edit fa-fw"></i></a><br/>
							<a href="remove-lrmds.php?id='.$rowsubject['SubNo'].'&Category=Elementary" title="Delete" class="btn btn-warning" style="margin:4px;padding:4px;"><i class="fa fa-trash-o fa-fw"></i></a>
						</td>											
						</tr>';
							$noOfLeaner=$noOfLeaner+$rowsubject['No_of_learner'];
							$totaleng=$totaleng+$rowsubject['English'];
							$totalscien=$totalscien+$rowsubject['Science'];
							$totalMath=$totalMath+$rowsubject['Math'];
							$totalFil=$totalFil+$rowsubject['Filipino'];
							$totalAral=$totalAral+$rowsubject['AralPan'];
							$totalEsp=$totalEsp+$rowsubject['ESP'];
							$totaltle=$totaltle+$rowsubject['TLE'];
							$totalmusic=$totalmusic+$rowsubject['MAPEH'];
							$totalarts=$totalarts+$rowsubject['Mother_tongue'];
							//$totalRO=$totalRO+$rowsubject['RO_Thematic'];
							$totalPR=$totalPR+$rowsubject['Project_Rush'];
															
							$subtotal=$subtotal+$total;
		}
			echo '<tr>
					<th>Total:</th>
						<td>'.number_format($noOfLeaner,0).'</td>
						<td>'.number_format($totaleng,0).'</td>
						<td>'.number_format($totalscien,0).'</td>
						<td>'.number_format($totalMath,0).'</td>
						<td>'.number_format($totalFil,0).'</td>
						<td>'.number_format($totalAral,0).'</td>
						<td>'.number_format($totalEsp,0).'</td>
						<td>'.number_format($totaltle,0).'</td>
						<td>'.number_format($totalmusic,0).'</td>
						<td>'.number_format($totalarts,0).'</td>
						
						<td>'.number_format($totalPR,0).'</td>
						<td>'.number_format($subtotal,0).'</td>
																
			</tr>';
														
  ?>
  </tbody>	
  </table>
  </div>