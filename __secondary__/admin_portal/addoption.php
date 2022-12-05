	<script>
		var loadFile = function(event) {
			var output = document.getElementById('pic');
			output.src = URL.createObjectURL(event.target.files[0]);
		};
	</script>

	<?php
	if (!is_dir('../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'])) {
		mkdir('../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'], 0777, true);
	}

	if (isset($_POST['upload'])) {
		$myfile = $_FILES['introimage']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$temp = $_FILES['introimage']['tmp_name'];
		$type = $_FILES['introimage']['type'];
		$ext = pathinfo($myfile, PATHINFO_EXTENSION);
		$mynewimage = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/' . $_GET['m'] . '.' . $ext;
		move_uploaded_file($temp, $mynewimage);

		mysqli_query($con, "UPDATE tbl_activity_sheets_instruction SET Picture='" . $mynewimage . "' WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' LIMIT 1");

		if (mysqli_affected_rows($con) == 1) {
	?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>


		<?php
		}
	} elseif (isset($_POST['addnew'])) {

		//   if ( $_SESSION['activty']=='MATCHING TYPE' ||  $_SESSION['activty']=='Matching Type' || $_SESSION['activty']=='Identification' || $_SESSION['activty']=='IDENTIFICATION ' || $_SESSION['activty']=='True or False' || $_SESSION['activty']=='TRUE OR FALSE')
		// {
		$Num = 1;
		while ($Num <= $_SESSION['ItemNo']) {
			$data = $_POST['QA'];
			$data = str_replace("'", "\'", $data);
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $Num . "','" . $data . "','-','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");

			$Num++;
		}
		//}else{
		//$data=$_POST['QA'];
		//$data=str_replace("'","\'",$data); 
		//mysqli_query($con,"INSERT INTO tbl_activity_sheets_option VALUES (NULL,'".$_GET['QNo']."','". $data."','-','".$_SESSION['SubCode']."','".$_GET['m']."','')");
		//}
		if (mysqli_affected_rows($con) == 1) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>


		<?php
		}
	} elseif (isset($_POST['set_answer'])) {
		$data = $_POST['Answer'];
		$data = str_replace("'", "\'", $data);

		mysqli_query($con, "UPDATE tbl_activity_sheets SET Correct_Answer='" . $data . "' WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' AND Activity_No='" . $_GET['QNo'] . "' LIMIT 1");
		if (mysqli_affected_rows($con) == 1) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>


		<?php
		}
	} elseif (isset($_POST['newinstruction'])) {
		$Instruct = $_POST['instruction'];
		$Instruct = str_replace("'", "\'", $Instruct);

		$query = mysqli_query($con, "SELECT * FROM tbl_activity_sheets_instruction WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_POST['QCode'] . "'");
		if (mysqli_num_rows($query) == 0) {
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_instruction VALUES (NULL,'" . $_SESSION['SubCode'] . "','" . $_POST['QCode'] . "','" . $Instruct . "','')");
		} else {
			mysqli_query($con, "UPDATE tbl_activity_sheets_instruction SET Activity_Instruction='" . $Instruct . "' WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_POST['QCode'] . "' LIMIT 1");
		}
		if (mysqli_affected_rows($con) == 1) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>
		<?php
		}
	} elseif (isset($_POST['SAVE'])) {

		if (!is_dir('../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option')) {
			mkdir('../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option', 0777, true);
		}
		//Option A Picture
		$myfileA = $_FILES['imageA']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$tempA = $_FILES['imageA']['tmp_name'];
		$type = $_FILES['imageA']['type'];
		$ext = pathinfo($myfileA, PATHINFO_EXTENSION);
		$mynewimageA = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option/' . $myfileA . '.' . $ext;
		move_uploaded_file($tempA, $mynewimageA);

		//Option B Picture
		$myfileB = $_FILES['imageB']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$tempB = $_FILES['imageB']['tmp_name'];
		$type = $_FILES['imageB']['type'];
		$ext = pathinfo($myfileB, PATHINFO_EXTENSION);
		$mynewimageB = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option/' . $myfileB . '.' . $ext;
		move_uploaded_file($tempB, $mynewimageB);
		//Option C Picture
		$myfileC = $_FILES['imageC']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$tempC = $_FILES['imageC']['tmp_name'];
		$type = $_FILES['imageC']['type'];
		$ext = pathinfo($myfileC, PATHINFO_EXTENSION);
		$mynewimageC = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option/' . $myfileC . '.' . $ext;
		move_uploaded_file($tempC, $mynewimageC);
		//Option D Picture
		$myfileD = $_FILES['imageD']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$tempD = $_FILES['imageD']['tmp_name'];
		$type = $_FILES['imageD']['type'];
		$ext = pathinfo($myfileD, PATHINFO_EXTENSION);
		$mynewimageD = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option/' . $myfileD . '.' . $ext;
		move_uploaded_file($tempD, $mynewimageD);
		//Option E Picture
		$myfileE = $_FILES['imageE']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$tempE = $_FILES['imageE']['tmp_name'];
		$type = $_FILES['imageE']['type'];
		$ext = pathinfo($myfileE, PATHINFO_EXTENSION);
		$mynewimageE = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/option/' . $myfileE . '.' . $ext;
		move_uploaded_file($tempE, $mynewimageE);

		if ($myfileA <> "") {
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','','A','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $mynewimageA . "')");
		} else {

			//Letter A
			$A = $_POST['A'];
			$A = str_replace("'", "\'", $A);
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','" . $A . "','A','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");
		}
		if ($myfileB <> "") {
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','','B','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $mynewimageB . "')");
		} else {
			//Letter B
			$B = $_POST['B'];
			$B = str_replace("'", "\'", $B);
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','" . $B . "','B','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");
		}


		if ($myfileC <> "") {
			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','','C','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $mynewimageC . "')");
		} else {
			//Letter C
			if ($_POST['C'] <> "") {
				$C = $_POST['C'];
				$C = str_replace("'", "\'", $C);
				mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','" . $C . "','C','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");
			}
		}

		if ($myfileD <> "") {

			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','','D','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $mynewimageD . "')");
		} else {

			//Letter D
			if ($_POST['D'] <> "") {
				$D = $_POST['D'];
				$D = str_replace("'", "\'", $D);
				mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','" . $D . "','D','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");
			}
		}
		if ($myfileE <> "") {

			mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','','E','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $mynewimageE . "')");
		} else {

			//Letter E
			if ($_POST['E'] <> "") {
				$E = $_POST['E'];
				$E = str_replace("'", "\'", $E);
				mysqli_query($con, "INSERT INTO tbl_activity_sheets_option VALUES (NULL,'" . $_GET['QNo'] . "','" . $E . "','E','" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','')");
			}
		}
		// mysqli_query($con,"UPDATE tbl_activity_sheets SET Correct_Answer='".$_POST['Answer']."' WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$_GET['QNo']."' LIMIT 1");
		if (mysqli_affected_rows($con) == 1) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>


		<?php
		}
	} elseif (isset($_POST['SAVEPIC'])) {
		$myfile = $_FILES['image']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$temp = $_FILES['image']['tmp_name'];
		$type = $_FILES['image']['type'];
		$ext = pathinfo($myfile, PATHINFO_EXTENSION);
		$mynewimage = '../pcdmis/reading_materials/' . $_GET['QNo'] . '/' . $_GET['m'] . '/' . $myfile . '.' . $ext;
		move_uploaded_file($temp, $mynewimage);
		$query = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' AND Activity_No='" . $_GET['QNo'] . "'");
		if (mysqli_num_rows($query) == 1) {
			mysqli_query($con, "UPDATE tbl_activity_sheets SET Link_picture='" . $mynewimage . "' WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' AND Activity_No='" . $_GET['QNo'] . "'");
		} else {
			mysqli_query($con, "INSERT INTO tbl_activity_sheets VALUES(NULL,'" . $_SESSION['SubCode'] . "','" . $_GET['m'] . "','" . $_GET['QNo'] . "','','','','" . $mynewimage . "')");
		}
		if (mysqli_affected_rows($con) == 1) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#access').modal({
						show: 'true'
					});
				});
			</script>


	<?php
		}
	}




	//Module Information
	$mymodule = mysqli_query($con, "SELECT * FROM tbl_list_of_module_activity WHERE ModuleCode='" . $_SESSION['Access'] . "' LIMIT 1");
	$rowmodule = mysqli_fetch_assoc($mymodule);
	//Activity Information
	$result = mysqli_query($con, "SELECT * FROM tbl_written_work_set_activity WHERE QCode ='" . $_GET['m'] . "'");
	$row = mysqli_fetch_assoc($result);
	$_SESSION['Type_of_activty'] = $row['Type_of_activity'];
	$_SESSION['activty'] = $row['Name_of_activity'];


	echo '<div class="modal-header">
          <a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access=' . urlencode(base64_encode($_SESSION['Access'])) . '&Item=' . urlencode(base64_encode("1")) . '&v=' . urlencode(base64_encode("addreadingmaterial")) . '" class="close" data-dismiss="modal">&times;</a>
          <h3 class="modal-title" style="text-transform:uppercase;">Module Title: ' . $rowmodule['Filename'] . '</h3>
		 <form action ="" method="POST" enctype="multipart/form-data">
		 <input type="file" name="introimage">
		 <input type="submit" name="upload" value="ADD" class="btn btn-info"><form>
		  <a href="#newinstruction" data-toggle="modal" class="btn btn-primary" style="float:right;">Directions</a>
        </div>
        <div class="modal-body">
		
		
		<div class="col-lg-8">';

	echo '
		  <div class="alert alert-success" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;">';
	echo $_GET['m'];
	//Instruction details
	$direction = mysqli_query($con, "SELECT * FROM tbl_activity_sheets_instruction WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' LIMIT 1");
	$rowdirect = mysqli_fetch_assoc($direction);

	//Question Data
	$myquestion = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' AND Activity_No='" . $_GET['QNo'] . "'");
	$rowquestion = mysqli_fetch_assoc($myquestion);

	echo '<p style="color:black;">' . $rowdirect['Activity_Instruction'] . '</p>';
	if ($rowdirect['Picture'] <> "") {
		echo '<img src="' . $rowdirect['Picture'] . '" style="width:100%; height:auto;cursor:pointer;" title="' . $rowdirect['Picture'] . '">';
	}

	echo '<hr/>';
	if ($rowquestion['Activity_question'] <> NULL) {
		echo '<h4>' . $_GET['QNo'] . '. ' . $rowquestion['Activity_question'] . '</h4>
		<img src="' . $rowquestion['Link_picture'] . '" style="width:60%;height:auto;" id="pic">';
	} else {
		echo $_GET['QNo'] . '. <img src="' . $rowquestion['Link_picture'] . '" style="width:60%;height:auto;"id="pic">
			';
	}
	echo '<hr/><form action ="" method="POST" enctype="multipart/form-data">
			<input type="file" name="image" onchange="loadFile(event)">
			<input type="submit" name="SAVEPIC" value="SAVE" class="btn btn-primary"> 
		</form>';
	echo '</div><form action ="" method="POST" enctype="multipart/form-data">
		 <div class="alert alert-info" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;">
		';



	if ($row['Name_of_activity'] == 'MULTIPLE CHOICE') {
		$mydata = mysqli_query($con, "SELECT * FROM tbl_activity_sheets_option WHERE QNumber='" . $_GET['QNo'] . "' AND SubCode='" . $_SESSION['SubCode'] . "' AND Activity_code='" . $_GET['m'] . "'");
		if (mysqli_num_rows($mydata) <> 0) {
			while ($rowoption = mysqli_fetch_array($mydata)) {
				$queoption = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $rowoption['Activity_code'] . "' AND Activity_No='" . $rowoption['QNumber'] . "'");
				$rowopanswer = mysqli_fetch_assoc($queoption);
				if ($rowopanswer['Correct_Answer'] == $rowoption['Letter']) {
					echo '<div class="radio">';
					if ($rowoption['QOption'] == NULL) {
						echo '<label>
											<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['Letter'] . '" required checked>
											<img src="' . $rowoption['Picture_link'] . '">
										 </label>';
					} else {
						echo '<label>
											<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['Letter'] . '" required checked>' . $rowoption['QOption'] . '
										 </label>';
					}
					echo '</div>';
				} else {
					echo '<div class="radio">';
					if ($rowoption['QOption'] == NULL) {
						echo '
							        <label>
									 <input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['Letter'] . '" required><img src="' . $rowoption['Picture_link'] . '">
								    </label>
									';
					} else {
						echo '
								      <label>
									    <input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['Letter'] . '" required>' . $rowoption['QOption'] . '
								     </label>
								 ';
					}
					echo '</div>';
				}
			}
			echo '<hr/><input type="submit" name="set_answer" id="answer" class="btn btn-primary" value="SET ANSWER">';
		} else {

			echo '<div class="form-group">
                        <div class="form-group input-group">
                            <span class="input-group-addon">A</span>
                            <input type="text" name="A" class="form-control" placeholder="Option A">
							 <span class="input-group-addon"><input type="file" name="imageA"></span>
                        </div>';

			echo '<div class="form-group input-group">
                            <span class="input-group-addon">B</span>
                            <input type="text" name="B" class="form-control" placeholder="Option B">
							
							  <span class="input-group-addon"><input type="file" name="imageB"></span>
                        </div>';

			echo '<div class="form-group input-group">
                            <span class="input-group-addon">C</span>
                            <input type="text" name="C" class="form-control" placeholder="Option C">
							 <span class="input-group-addon"><input type="file" name="imageC"></span>
                        </div>';

			echo '<div class="form-group input-group">
                            <span class="input-group-addon">D</span>
                            <input type="text" name="D" class="form-control" placeholder="Option D">
							  <span class="input-group-addon"><input type="file" name="imageD"></span>
                        </div>';

			echo '<div class="form-group input-group">
                            <span class="input-group-addon">E</span>
                            <input type="text" name="E" class="form-control" placeholder="Option E">
							 <span class="input-group-addon"><input type="file" name="imageE"></span>
                        </div>';

			echo '<hr/>';
			echo '<input type="submit" name="SAVE" id="answer" class="btn btn-primary" value="SUBMIT">';
		}
	} else {
		$myoption = mysqli_query($con, "SELECT * FROM tbl_activity_sheets_option WHERE QNumber='" . $_GET['QNo'] . "' AND SubCode='" . $_SESSION['SubCode'] . "' AND Activity_code='" . $_GET['m'] . "'");

		while ($rowoption = mysqli_fetch_array($myoption)) {
			$queoption = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $rowoption['Activity_code'] . "' AND Activity_No='" . $rowoption['QNumber'] . "'");
			$rowopanswer = mysqli_fetch_assoc($queoption);
			if ($rowopanswer['Correct_Answer'] == $rowoption['QOption']) {
				echo '<div class="radio">';
				if ($rowoption['QOption'] == NULL) {
					echo '<label>
									<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['QOption'] . '" required checked>
									<img src="' . $rowoption['Picture_link'] . '">
								 </label>';
				} else {
					echo '<label>
									<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['QOption'] . '" required checked>' . $rowoption['QOption'] . '
								 </label>';
				}
				echo '</div>';
			} else {
				echo '<div class="radio">';
				if ($rowoption['QOption'] == NULL) {
					echo '<label>
										<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['Letter'] . '" required>' . $rowoption['Letter'] . '. <img src="' . $rowoption['Picture_link'] . '">
									 </label>';
				} else {
					echo '<label>
										<input type="radio" name="Answer" id="optionsRadios1" value="' . $rowoption['QOption'] . '" required>' . $rowoption['QOption'] . '
									 </label>';
				}
				echo '</div>';
			}
		}
	}


	if ($_SESSION['activty'] <> 'MULTIPLE CHOICE') {
		echo '<hr/>';
		echo '<a href="#newoption" data-toggle="modal" class="btn btn-success" style="float:right;">Add Selection</a>';
		echo '<input type="submit" name="set_answer" id="answer" class="btn btn-primary" value="SET ANSWER">';
	}




	?>
	</form>
	</div>

	</div>
	</div>

	<div class="col-lg-4">
		<div class="alert alert-info" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:14px;text-transform:uppercase;">
			<?php
			$Number = 1;
			echo '<p><b>Activity #: ' . $_GET['QNo'] . '  ' . $row['Type_of_activity'] . ' (' . $row['Name_of_activity'] . ')</b></p><hr/>';
			while ($Number <= $_SESSION['ItemNo']) {
				$queop = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $_GET['m'] . "' AND Activity_No='" . $Number . "'");
				$rowop = mysqli_fetch_assoc($queop);
				if ($rowop['Correct_Answer'] <> "") {
					echo '<a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&QNo=' . urlencode(base64_encode($Number)) . '&m=' . urlencode(base64_encode($_GET['m'])) . '&v=' . urlencode(base64_encode("addoption")) . '" class="btn btn-success" style="height:60px;padding:10px;margin:4px;">' . $Number . '</a>';
				} else {
					echo '<a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&QNo=' . urlencode(base64_encode($Number)) . '&m=' . urlencode(base64_encode($_GET['m'])) . '&v=' . urlencode(base64_encode("addoption")) . '" class="btn btn-secondary" style="height:60px;padding:10px;margin:4px;">' . $Number . '</a>';
				}
				$Number++;
			}
			$querydata = mysqli_query($con, "SELECT * FROM tbl_written_work_set_activity WHERE QCode='" . $_GET['m'] . "' LIMIT 1");
			$rowstatus = mysqli_fetch_assoc($querydata);
			echo '<h4 style="padding:4px;">Activity sheet is currently ' . $rowstatus['Activity_status'] . ' <a href="change_status.php?status=' . $rowstatus['Activity_status'] . '&code=' . $_GET['m'] . '&QNo=1">Change</a></h4>';

			?>

		</div>
	</div>
	<!-- Modal for Re-assign-->
	<div class="panel-body">
		<!-- Modal -->
		<div class="modal fade" id="newoption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
						<h3 class="modal-title text-center">Add new selection</h3>

					</div>
					<form action="" Method="POST" enctype="multipart/form-data">
						<div class="modal-body">
							<label>Enter Selection information</label>
							<input type="text" name="QA" class="form-control" placeholder="Type new selection data" required>
						</div>
						<div class="modal-footer">
							<input type="submit" name="addnew" value="SUBMIT" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for Re-assign-->
	<div class="panel-body">
		<!-- Modal -->
		<div class="modal fade" id="newinstruction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
						<h3 class="modal-title text-center">Activity Instruction</h3>

					</div>
					<form action="" Method="POST" enctype="multipart/form-data">
						<div class="modal-body">
							<label>Enter Activity Intruction</label>
							<input type="hidden" name="QCode" value="<?php echo $row['QCode']; ?>">
							<textarea class="form-control" rows="4" name="instruction" placeholder="Enter Instruction"></textarea>
						</div>
						<div class="modal-footer">
							<input type="submit" name="newinstruction" value="SUBMIT" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>