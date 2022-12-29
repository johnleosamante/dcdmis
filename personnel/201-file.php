<?php
if (!is_dir('../pcdmis/201_files/' . $_SESSION[GetSiteAlias() . '_EmpID'])) {
	mkdir('../pcdmis/201_files/' . $_SESSION[GetSiteAlias() . '_EmpID'], 0777, true);
}

$_SESSION[GetSiteAlias() . '_pathlocation'] = '../pcdmis/201_files/' . $_SESSION[GetSiteAlias() . '_EmpID'];
?>

<div class="row">
  	<div class="col-lg-12">
  		<?php
		$_SESSION[GetSiteAlias() . '_pathlocation'] = '../pcdmis/201_files/' . $_SESSION[GetSiteAlias() . '_EmpID'];
		$emp_info = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'") or die("Error information data");
		$data = mysqli_fetch_assoc($emp_info);
		echo '<img src="../pcdmis/images/' . $data['Picture'] . '" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
		echo '<h3>Employee ID: ' . $_SESSION[GetSiteAlias() . '_EmpID'] . '</h3>';
		echo '<h3>Employee Name: ' . utf8_encode($data['Emp_LName'] . ', ' . $data['Emp_FName'] . ' ' . $data['Emp_MName']) . '</h3>';
		echo '<h3>Station: ' . $data['SchoolName'] . '</h3>';
		echo '<h3>Birthdate: ' . $data['Emp_Month'] . '/' . $data['Emp_Day'] . '/' . $data['Emp_Year'] . '</h3>';
		$_SESSION[GetSiteAlias() . '_surname'] = $data['Emp_LName'];
		$_SESSION[GetSiteAlias() . '_given'] = $data['Emp_FName'];
		$_SESSION[GetSiteAlias() . '_middle'] = mb_strimwidth($data['Emp_MName'], 0, 1);
		$_SESSION[GetSiteAlias() . '_birth'] = $data['Emp_Month'] . '/' . $data['Emp_Day'] . '/' . $data['Emp_Year'];
		$_SESSION[GetSiteAlias() . '_place'] = $data['Emp_place_of_birth'];
		?>
  	</div>
	
  	<div class="col-lg-12">
  		<div class="panel-body">
  			<?php
			$dir = $_SESSION[GetSiteAlias() . '_pathlocation']; // Directory where files are stored

			if ($dir_list = opendir($dir)) {
				while (($filename = readdir($dir_list)) != false) {
			?>
  			
			<p><a href="<?php echo $_SESSION[GetSiteAlias() . '_pathlocation'] . '/' . $filename; ?>" target="_blank"><?php echo $filename; ?></a></p>
  			
			<?php
				}

				closedir($dir_list);
			}
			?>
  		</div><!-- .panel-body -->
  	</div><!-- .panel -->
</div>