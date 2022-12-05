<style>
	th,
	td {
		text-transform: uppercase;
	}
</style>

<script>
	function submit_question() {
		$.ajax({
			type: 'POST',
			url: 'save_question.php',
			data: $('#frmBox').serialize(),
			success: function(response) {
				$('#success').html(response);
			}

		});

		var form = document.getElementById('frmBox').reset();
		//document.getElementById('message').setFucos;
		return false;
	}
</script>


<?php

$subject = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_subject WHERE RATSubCode ='" . $_SESSION['SubCode'] . "' LIMIT 1");
$rowsub = mysqli_fetch_assoc($subject);
$myquiz = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_questionaires WHERE SubCode='" . $_GET['subcode'] . "'");
$No = mysqli_num_rows($myquiz) + 1;


//image for option
if (!is_dir('../quiz/' . $_SESSION['SubCode'] . '/' . $No)) {
	mkdir('../quiz/' . $_SESSION['SubCode'] . '/' . $No, 0777, true);
}

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php
		echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code=' . urlencode(base64_encode($_SESSION['SubCode'])) . '&GLevel=' . urlencode(base64_encode($_SESSION['GLevel'])) . '&v=' . urlencode(base64_encode("Questionnairs")) . '" style="float:right;" class="btn btn-secondary">Back</a>';
		if ($_SESSION['No'] <> "") {
			echo '<h4>Questionnairs information for Number  <label>' . $_SESSION['No'] . '</label></h4>';
		} else {
			echo '<h4>Questionnairs information for Number  <label>' . $No . '</label></h4>';
		}
		if (isset($_POST['submitQues'])) {
			$data = $_POST['QA'];
			$data = str_replace("'", "\'", $data);

			mysqli_query($con, "INSERT INTO tbl_assessment_rat_questionaires VALUES(NULL,'" . $No . "','" . $data . "','-','" . $_SESSION['SubCode'] . "','0','')");
			mysqli_query($con, "UPDATE tbl_assessment_rat_questionaires SET tbl_assessment_rat_questionaires.Answer ='" . $_POST['Answer'] . "' WHERE tbl_assessment_rat_questionaires.QNumber ='" . $No . "' AND tbl_assessment_rat_questionaires.SubCode='" . $_SESSION['SubCode'] . "' LIMIT 1");

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
		} elseif (isset($_POST['AddQuestion'])) {
			$data = $_POST['QA'];
			$data = str_replace("'", "\'", $data);

			mysqli_query($con, "INSERT INTO tbl_assessment_rat_questionaires VALUES(NULL,'" . $No . "','" . $data . "','-','" . $_SESSION['SubCode'] . "','0','')");

			//Option Letter A   
			$queryA = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
			$dataA = $_POST['A'];
			$dataA = str_replace("'", "\'", $dataA);
			if (mysqli_num_rows($queryA) == 1) {
				$opA = mysqli_fetch_assoc($queryA);
				if ($opA['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataA . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $No . "','" . $dataA . "','A','" . $_SESSION['SubCode'] . "','')");
			}
			//Option Letter B  
			$queryB = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
			$dataB = $_POST['B'];
			$dataB = str_replace("'", "\'", $dataB);
			if (mysqli_num_rows($queryB) == 1) {
				$opB = mysqli_fetch_assoc($queryB);
				if ($opB['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataB . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $No . "','" . $dataB . "','B','" . $_SESSION['SubCode'] . "','')");
			}

			//Option Letter C  
			$queryC = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
			$dataC = $_POST['C'];
			$dataC = str_replace("'", "\'", $dataC);
			if (mysqli_num_rows($queryC) == 1) {
				$opC = mysqli_fetch_assoc($queryC);
				if ($opC['QOption'] <> "") {

					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataC . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $No . "','" . $dataC . "','C','" . $_SESSION['SubCode'] . "','')");
			}
			//Option Letter D  
			$queryD = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
			$dataD = $_POST['D'];
			$dataD = str_replace("'", "\'", $dataD);
			if (mysqli_num_rows($queryD) == 1) {
				$opD = mysqli_fetch_assoc($queryD);
				if ($opD['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataD . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $No . "','" . $dataD . "','D','" . $_SESSION['SubCode'] . "','')");
			}
			//Option Letter E 
			if ($_POST['E'] <> "") {
				$queryE = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
				$dataE = $_POST['E'];
				$dataE = str_replace("'", "\'", $dataE);
				if (mysqli_num_rows($queryE) == 1) {
					$opE = mysqli_fetch_assoc($queryE);
					if ($opE['QOption'] <> "") {
						mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataE . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
					}
				} else {
					mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $No . "','" . $dataE . "','E','" . $_SESSION['SubCode'] . "','')");
				}
			}
			mysqli_query($con, "UPDATE tbl_assessment_rat_questionaires SET tbl_assessment_rat_questionaires.Answer ='" . $_POST['Answer'] . "' WHERE tbl_assessment_rat_questionaires.QNumber ='" . $No . "' AND tbl_assessment_rat_questionaires.SubCode='" . $_SESSION['SubCode'] . "' LIMIT 1");

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
		} elseif (isset($_POST['submitQuestion'])) {
			$data = $_POST['QA'];
			$data = str_replace("'", "\'", $data);

			mysqli_query($con, "UPDATE tbl_assessment_rat_questionaires SET Questionnairs='" . $data . "' WHERE QNumber ='" . $_SESSION['No'] . "' AND SubCode='" . $_SESSION['SubCode'] . "' LIMIT 1");


			//Option Letter A   
			$queryA = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
			$dataA = $_POST['A'];
			$dataA = str_replace("'", "\'", $dataA);

			if (mysqli_num_rows($queryA) == 1) {
				$opA = mysqli_fetch_assoc($queryA);
				if ($opA['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataA . "' WHERE tbl_assessment_rat_option.QNumber='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $_SESSION['No'] . "','" . $dataA . "','A','" . $_SESSION['SubCode'] . "','')");
			}



			//Option Letter B  
			$queryB = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
			$dataB = $_POST['B'];
			$dataB = str_replace("'", "\'", $dataB);
			if (mysqli_num_rows($queryB) == 1) {
				$opB = mysqli_fetch_assoc($queryB);
				if ($opB['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataB . "' WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $_SESSION['No'] . "','" . $dataB . "','B','" . $_SESSION['SubCode'] . "','')");
			}

			//Option Letter C  
			$queryC = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
			$dataC = $_POST['C'];
			$dataC = str_replace("'", "\'", $dataC);
			if (mysqli_num_rows($queryC) == 1) {
				$opC = mysqli_fetch_assoc($queryC);
				if ($opC['QOption'] <> "") {

					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataC . "' WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $_SESSION['No'] . "','" . $dataC . "','C','" . $_SESSION['SubCode'] . "','')");
			}
			//Option Letter D  
			$queryD = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
			$dataD = $_POST['D'];
			$dataD = str_replace("'", "\'", $dataD);
			if (mysqli_num_rows($queryD) == 1) {
				$opD = mysqli_fetch_assoc($queryD);
				if ($opD['QOption'] <> "") {
					mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataD . "' WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
				}
			} else {
				mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $_SESSION['No'] . "','" . $dataD . "','D','" . $_SESSION['SubCode'] . "','')");
			}
			//Option Letter E 
			if ($_POST['E'] <> "") {
				$queryE = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
				$dataE = $_POST['E'];
				$dataE = str_replace("'", "\'", $dataE);
				if (mysqli_num_rows($queryE) == 1) {
					$opE = mysqli_fetch_assoc($queryE);
					if ($opE['QOption'] <> "") {
						mysqli_query($con, "UPDATE tbl_assessment_rat_option SET QOption = '" . $dataE . "' WHERE tbl_assessment_rat_option.QNumber='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
					}
				} else {
					mysqli_query($con, "INSERT tbl_assessment_rat_option VALUES(NULL,'" . $_SESSION['No'] . "','" . $dataE . "','E','" . $_SESSION['SubCode'] . "','')");
				}
			}
			mysqli_query($con, "UPDATE tbl_assessment_rat_questionaires SET tbl_assessment_rat_questionaires.Answer ='" . $_POST['Answer'] . "' WHERE tbl_assessment_rat_questionaires.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_questionaires.SubCode='" . $_SESSION['SubCode'] . "' LIMIT 1");

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
		} elseif (isset($_POST['AddPicture'])) {
			$myfile = $_FILES['image']['name'];
			//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
			$temp = $_FILES['image']['tmp_name'];
			$type = $_FILES['image']['type'];
			$ext = pathinfo($myfile, PATHINFO_EXTENSION);
			//unlink('../quiz/'.$_SESSION['SubCode'].'/'.$_SESSION['No'].'.'.$ext);
			$mynewimage = '../quiz/' . $_SESSION['SubCode'] . '/' . $_SESSION['No'] . '.' . $ext;

			move_uploaded_file($temp, $mynewimage);
			$try = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_questionaires WHERE QNumber ='" . $_SESSION['No'] . "' AND SubCode='" . $_SESSION['SubCode'] . "'");
			if (mysqli_num_rows($try) == 0) {
				mysqli_query($con, "INSERT INTO tbl_assessment_rat_questionaires VALUES(NULL,'" . $_SESSION['No'] . "','','-','" . $_SESSION['SubCode'] . "','0','" . $mynewimage . "')");
			}
		} elseif (isset($_POST['AddOption'])) {
			$newno = 0;
			if ($_SESSION['No'] == "") {
				$newno = $No;
			} else {
				$newno = $_SESSION['No'];
			}
			$myfile = $_FILES['image']['name'];
			//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
			$temp = $_FILES['image']['tmp_name'];
			$type = $_FILES['image']['type'];
			$ext = pathinfo($myfile, PATHINFO_EXTENSION);
			//unlink('../quiz/'.$_SESSION['SubCode'].'/'.$_SESSION['No'].'.'.$ext);
			$mynewimage = '../quiz/' . $_SESSION['SubCode'] . '/' . $newno . '/' . $_SESSION['OpPic'] . '.' . $ext;

			move_uploaded_file($temp, $mynewimage);

			$try = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $newno . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='" . $_SESSION['OpPic'] . "'");
			if (mysqli_num_rows($try) == 0) {
				mysqli_query($con, "INSERT INTO tbl_assessment_rat_option VALUES(NULL,'" . $newno . "','','" . $_SESSION['OpPic'] . "','" . $_SESSION['SubCode'] . "','" . $mynewimage . "')");
			}
		}
		?>
	</div>

	<!-- /.panel-heading -->
	<div class="panel-body">
		<form action="" Method="POST" enctype="multipart/form-data" id="frmBox">
			<?php
			echo '<a href="myexampic.php?No=' . urlencode(base64_encode($No)) . '" title="Click to browsed" data-toggle="modal" data-target="#myexam" style="float:right;" class="btn btn-primary">Upload Image</a>';


			echo '<label> Grade Level: Grade ' . $_SESSION['GLevel'] . '</label><br/>
				<label>Learning Area: ' . $rowsub['Learning_Areas'] . ' Subject </label><br/>
				<label># of Item: ' . $rowsub['No_of_Items'] . ' Items </label><hr/>';
			if ($_SESSION['No'] <> "") {
				$quiz = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_questionaires WHERE QNumber ='" . $_SESSION['No'] . "' AND SubCode='" . $_SESSION['SubCode'] . "'");
				$rowquiz = mysqli_fetch_assoc($quiz);
				echo '<img src="' . $rowquiz['Link_picture'] . '" style="width:70%;">';
				echo '<textarea name="QA" class="form-control" rows="2" style="float:right;padding:4px;margin:4px;"></textarea><br/><br/><br/><br/>';
			} else {

				echo '<textarea name="QA" class="form-control" rows="3" style="float:right;padding:4px;margin:4px;" required></textarea><br/><br/><br/><br/>';
			}

			//Display all option

			//Option A	 
			if ($_SESSION['No'] <> NULL) {
				$myoptiondataA = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
			} else {
				$myoptiondataA = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='A'");
			}
			if (mysqli_num_rows($myoptiondataA) == 0) {
				echo '<div class="form-group input-group">
			<span class="input-group-addon">A</span>
			<input type="text" name="A" class="form-control" id="AnsA" value="" placeholder="Enter Option A" required>
			<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("A")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			} else {
				$myopPicA = mysqli_fetch_assoc($myoptiondataA);
				echo '<div class="form-group input-group">
			<span class="input-group-addon">A</span>';
				if ($myopPicA['QOption'] <> "") {
					echo '<input type="text" name="A" class="form-control" value="' . $myopPicA['QOption'] . '" placeholder="Enter Option A" required>';
				} else {
					$_SESSION['NoOp'] = 1;
					echo '<img src="' . $myopPicA['Picture_link'] . '">';
				}

				echo '<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("A")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			}

			//Option B
			if ($_SESSION['No'] <> NULL) {
				$myoptiondataB = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
			} else {
				$myoptiondataB = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='B'");
			}
			if (mysqli_num_rows($myoptiondataB) == 0) {
				echo '<div class="form-group input-group">
			<span class="input-group-addon">B</span>
			<input type="text" name="B" class="form-control" id="AnsB" value="" placeholder="Enter Option B" required>
			<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("B")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			} else {
				$myopPicB = mysqli_fetch_assoc($myoptiondataB);
				echo '<div class="form-group input-group">
			<span class="input-group-addon">B</span>';
				if ($myopPicB['QOption'] <> "") {
					echo '<input type="text" name="B" class="form-control" value="' . $myopPicB['QOption'] . '" placeholder="Enter Option B" required>';
				} else {
					echo '<img src="' . $myopPicB['Picture_link'] . '">';
					$_SESSION['NoOp'] = 2;
				}
				echo '<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("B")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			}

			//Option C
			if ($_SESSION['No'] <> NULL) {
				$myoptiondataC = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
			} else {
				$myoptiondataC = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='C'");
			}
			if (mysqli_num_rows($myoptiondataC) == 0) {
				echo '<div class="form-group input-group">
			<span class="input-group-addon">C</span>
			<input type="text" name="C" class="form-control" id="AnsC" value="" placeholder="Enter Option C" required>
			<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("C")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			} else {
				$myopPicC = mysqli_fetch_assoc($myoptiondataC);
				echo '<div class="form-group input-group">
			<span class="input-group-addon">C</span>';
				if ($myopPicC['QOption'] <> "") {
					echo '<input type="text" name="C" class="form-control" value="' . $myopPicC['QOption'] . '" placeholder="Enter Option C" required>';
				} else {
					echo '<img src="' . $myopPicC['Picture_link'] . '">';
					$_SESSION['NoOp'] = 3;
				}
				echo '<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("C")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			}

			//Option D
			if ($_SESSION['No'] <> NULL) {
				$myoptiondataD = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
			} else {
				$myoptiondataD = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='D'");
			}
			if (mysqli_num_rows($myoptiondataD) == 0) {
				echo '<div class="form-group input-group">
			<span class="input-group-addon">D</span>
			<input type="text" name="D" class="form-control" id="AnsD" value="" placeholder="Enter Option D" required>
			<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("D")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			} else {
				$myopPicD = mysqli_fetch_assoc($myoptiondataD);
				echo '<div class="form-group input-group">
			<span class="input-group-addon">D</span>';
				if ($myopPicD['QOption'] <> "") {
					echo '<input type="text" name="D" class="form-control" value="' . $myopPicD['QOption'] . '" placeholder="Enter Option D" required>';
				} else {
					echo '<img src="' . $myopPicD['Picture_link'] . '">';
					$_SESSION['NoOp'] = 4;
				}
				echo '<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("D")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			}

			//Option E
			if ($_SESSION['No'] <> NULL) {
				$myoptiondataE = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $_SESSION['No'] . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
			} else {
				$myoptiondataE = mysqli_query($con, "SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber ='" . $No . "' AND tbl_assessment_rat_option.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_assessment_rat_option.Letter='E'");
			}
			if (mysqli_num_rows($myoptiondataE) == 0) {
				echo '<div class="form-group input-group">
			<span class="input-group-addon">E</span>
			<input type="text" name="E" class="form-control" id="AnsE" value="" placeholder="Enter Option E" >
			<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("E")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			} else {
				$myopPicE = mysqli_fetch_assoc($myoptiondataE);
				echo '<div class="form-group input-group">
			<span class="input-group-addon">E</span>';
				if ($myopPicE['QOption'] <> "") {
					echo '<input type="text" name="E" class="form-control" value="' . $myopPicE['QOption'] . '" placeholder="Enter Option E" >';
				} else {
					echo '<img src="' . $myopPicE['Picture_link'] . '">';
				}
				echo '<span class="input-group-addon"><a href="myoptionpic.php?Letter=' . urlencode(base64_encode("E")) . '" data-toggle="modal" data-target="#myexam">Upload</a></span>
			</div>';
			}



			echo '</div>
           <div class="modal-footer">
		   <label style="width:90%;float:left;">
		   <select name="Answer" class="form-control" title="Select as correct answer" required>
		     <option value="">--Select Answer--</option>
		     <option value="A">A</option>
		     <option value="B">B</option>
		     <option value="C">C</option>
		     <option value="D">D</option>
		     <option value="E">E</option>
		   </select>
		   </label>';

			if ($_SESSION['No'] <> NULL) {
				echo '<button type="submit" class="btn btn-success" name="submitQuestion">SUBMIT</button>';
			} elseif ($_SESSION['NoOp'] <> NULL) {
				echo '<button type="submit" class="btn btn-success" name="submitQues">ADD</button>';
			} else {
				echo '<button type="submit" class="btn btn-success" name="AddQuestion">SAVE</button>';
			}



			echo '</div>	
		
		 </form></div>';
			?>
			<!-- /.panel-body -->




			<!-- Modal for Re-assign-->
			<div class="panel-body">

				<!-- Modal -->
				<div class="modal fade" id="myexam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						</div>
					</div>
				</div>
			</div>






			<!-- Modal -->
			<div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div style="margin-left:auto;margin-right:auto;width:30%; height:25%;margin-top:50px;">

					<!-- Modal content-->
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
						</div>

						<div class="modal-body">
							<img src="../logo/check.png" width="100%" height="50%">
							<center>
								<h3>Successfully Save!</h3>
							</center>
						</div>
						<div class="modal-footer">
							<?php
							echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code=' . urlencode(base64_encode($_SESSION['SubCode'])) . '&GLevel=' . urlencode(base64_encode($_SESSION['GLevel'])) . '&v=' . urlencode(base64_encode("Questionnairs")) . '" class="btn btn-success" style="float:right;">OK</a>';
							?>
						</div>

					</div>
				</div>
			</div>