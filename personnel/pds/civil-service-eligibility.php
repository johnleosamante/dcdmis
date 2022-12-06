<div class="tab-pane fade" id="eligibility">
  <a href="#myelegibility" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>IV. Civil Service Eligibility </h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="25%" rowspan="2">Career Services / RA 1080 (BOARD / BAR) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
          <th width="15%" rowspan="2">Rating (if Applicable)</th>
          <th width="15%" rowspan="2">Date of Examinition Conferment</th>
          <th width="15%" rowspan="2">Place of Examinition / Conferment</th>
          <th width="20%" colspan="2">License(if Applicable)</th>
          <th colspan="2" width="7%"></th>
        </tr>
        <tr>
          <th>Number</th>
          <th>Date of Validity</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result3 = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
        while ($row3 = mysqli_fetch_array($result3)) {
          echo '<tr>
												<td style="text-align:center;">' . $row3['Carrer_Service'] . '</td>
												<td style="text-align:center;">' . $row3['Rating'] . '</td>
												<td style="text-align:center;">' . $row3['Date_of_Examination'] . '</td>
												<td style="text-align:center;">' . $row3['Place_of_Examination'] . '</td>
												<td style="text-align:center;">' . $row3['Number_of_Hour'] . '</td>
												<td style="text-align:center;">' . $row3['Date_of_Validity'] . '</td>
											
												<td style="text-align:center;">
													<a href="my_license.php?id=' . urlencode(base64_encode($row3['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
													<a style="cursor:pointer;" onclick="delete_service(this.id)" id="' . $row3['No'] . '">Remove</a>
																
													  </td>
											
											</tr>';
        }
        ?>

      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_service(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_service.php?id=' + id;
    }
  }
</script>

<!-- Modal for Civil SERVICE-->
<div class="modal fade" id="myelegibility" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">IV. CIVIL SERVICE ELIGIBILITY </h4>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group">
            <div style="overflow-x:auto;">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th rowspan="2" style="text-align:center;">CAREER SERVICES / RA 1080 (BOARD / BAR)<br /> UNDERSPECIAL LAWS / CES / CSEE <br />BARANGAY ELIGIBILITY/ DRIVERS LICENSE</th>
                  <th rowspan="2" style="text-align:center;">RATING <br />(if Applicable)</th>
                  <th rowspan="2" style="text-align:center;">DATE OF EXAMINATION <br /> CONFERMENT</th>
                  <th rowspan="2" style="text-align:center;">PLACE OF EXAMINATION / CONFERMENT</th>
                  <th colspan="2" style="text-align:center;">LICENSE(if Applicable)</th>
                </tr>
                <tr>
                  <th style="text-align:center;">NUMBER</th>
                  <th style="text-align:center;">Date of Validity</th>
                </tr>
                <tr>
                  <th><input type="text" name="Carrer" class="form-control" required></th>
                  <th><input type="text" name="rating" class="form-control" required></th>
                  <th><input type="date" name="date_exam" class="form-control" required></th>
                  <th><input type="text" name="Place" class="form-control" required></th>
                  <th><input type="text" name="license_number" class="form-control" required></th>
                  <th><input type="date" name="year" class="form-control" required></th>

                </tr>
              </table>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="save_CS" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="mylicense" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->