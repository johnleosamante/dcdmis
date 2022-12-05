<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data1)
{
$code=$_GET[$key]=base64_decode(urldecode($data1));
	
}
$_SESSION['Trancode']=$code;
?>

<div class="modal-header">

<h4 class="modal-title" id="myModalLabel">Update Transaction</h4>
</div>
<div style="margin:15px;">

</div>
<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		$data=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='".$code."' LIMIT 1");
		$row=mysqli_fetch_assoc($data);
		echo '
         <label>Transaction Code</label>
		<input type="text" class="form-control" value="'.$code.'"disabled>
	<label>Transaction Details</label>
		<textarea name="Qualname"  class="form-control" rows="5" required>'.$row['Title'].'</textarea>';
		$destination1=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='1' ORDER BY tbl_transaction_flow.SequenceNo Asc");
	    $setdestiny1=mysqli_fetch_assoc($destination1);
		
		echo '<label style="padding:4px;">Transaction Flow (1st Destination: RECORD)</label><br/>
		   <div class="row">
				
                <div class="col-lg-4">
				<label>1st Destination</label><br/>
				<select name="first" class="form-control">
				<option value="'.$setdestiny1['Destination_section'].'">'.$setdestiny1['Destination_section'].'</option>';
				
					echo '<option value="RECORD">RECORDS</option>';
				
				
				$destination2=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='2' ORDER BY tbl_transaction_flow.SequenceNo Asc");
				$setdestiny2=mysqli_fetch_assoc($destination2);
				
				echo '</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>2nd Destination</label><br/>
				 <select name="second" class="form-control">
				<option value="'.$setdestiny2['Destination_section'].'">'.$setdestiny2['Destination_section'].'</option>';
				
				
				$destiny2=mysqli_query($con,"SELECT * FROM tbl_deparment WHERE Offices<>'".$setdestiny2['Destination_section']."'");
				while ($row2=mysqli_fetch_array($destiny2))
				{
					echo '<option value="'.$row2['Offices'].'">'.$row2['Offices'].'</option>';
				}
				
				
				$destination3=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='3' ORDER BY tbl_transaction_flow.SequenceNo Asc");
				$setdestiny3=mysqli_fetch_assoc($destination3);
				
				echo '</select>
				</div>
				
				<div class="col-lg-4">
				 <label>3rd Destination</label><br/>
				<select name="third" class="form-control">
				<option value="'.$setdestiny3['Destination_section'].'">'.$setdestiny3['Destination_section'].'</option>';
				 
				$destiny3=mysqli_query($con,"SELECT * FROM tbl_deparment WHERE Offices<>'".$setdestiny3['Destination_section']."'");
				while ($row3=mysqli_fetch_array($destiny3))
				{
					echo '<option value="'.$row3['Offices'].'">'.$row3['Offices'].'</option>';
				}
				
				
				$destination4=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='4' ORDER BY tbl_transaction_flow.SequenceNo Asc");
				$setdestiny4=mysqli_fetch_assoc($destination4);
				
				echo '</select>
				
				</div>
			
	
			 <div class="col-lg-4">
				<label>4th Destination</label><br/>
				<select name="fourth" class="form-control">
				<option value="'.$setdestiny4['Destination_section'].'">'.$setdestiny4['Destination_section'].'</option>';
				 
				$destiny4=mysqli_query($con,"SELECT * FROM tbl_deparment WHERE Offices<>'".$setdestiny4['Destination_section']."'");
				while ($row4=mysqli_fetch_array($destiny4))
				{
					echo '<option value="'.$row4['Offices'].'">'.$row4['Offices'].'</option>';
				}
				
				$destination5=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='5' ORDER BY tbl_transaction_flow.SequenceNo Asc");
				$setdestiny5=mysqli_fetch_assoc($destination5);
				echo '</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>5th Destination</label><br/>
				 <select name="fitfh" class="form-control">
			     <option value="'.$setdestiny5['Destination_section'].'">'.$setdestiny5['Destination_section'].'</option>';
				
				$destiny6=mysqli_query($con,"SELECT * FROM tbl_deparment WHERE Offices<>'".$setdestiny5['Destination_section']."'");
				while ($row6=mysqli_fetch_array($destiny6))
				{
					echo '<option value="'.$row6['Offices'].'">'.$row6['Offices'].'</option>';
				}
				
				$destination6=mysqli_query($con,"SELECT * FROM tbl_transaction_flow WHERE tbl_transaction_flow.SchoolID ='".$_SESSION['school_id']."' AND tbl_transaction_flow.TransactionCode='".$code."' AND tbl_transaction_flow.SequenceNo='6' ORDER BY tbl_transaction_flow.SequenceNo Asc");
				$setdestiny6=mysqli_fetch_assoc($destination6);
				echo '</select>
				</div>
				
				<div class="col-lg-4">
				 <label>6th Destination</label><br/>
				<select name="six" class="form-control">
			<option value="'.$setdestiny6['Destination_section'].'">'.$setdestiny6['Destination_section'].'</option>';
				
				$destiny7=mysqli_query($con,"SELECT * FROM tbl_deparment WHERE Offices<>'".$setdestiny6['Destination_section']."'");
				while ($row7=mysqli_fetch_array($destiny7))
				{
					echo '<option value="'.$row7['Offices'].'">'.$row7['Offices'].'</option>';
				}
				
				echo '</select>
				
				</div>
				</div>
				</div>
		
		
			<div class="modal-footer">
				<input type="submit" name="update_trans" value="UPDATE" class="btn btn-primary">
				<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
		</form>';
		?>
		</div>
                                       