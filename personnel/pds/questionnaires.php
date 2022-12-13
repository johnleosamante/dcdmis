<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'questionnaires'); ?>" id="questionnaires">
  <h3 class="h4 mb-0">Questionnaires</h3>

  <form class="row mt-3" action="" Method="POST" enctype="multipart/form-data">
    <div class="col table-reponsive">
      <table width="100%" class="table table-striped table-bordered table-hover">
        <tbody>
          <tr>
            <td width="80%">
              <h6 class="h6">36. Are you related by sanguinity or affinity to any of the following:</h6>
              <ol type="a" class="mt-3">
                <li class="pb-5">Within the third degree (by National Government Employees):
                  appointing authority, recommending authority, chief of office/bureau/department of person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?</li>
                <li class="pb-5">Within the fourth degree (for Local Government Employees): appointing authority or recommending authority where you will be appointed?</li>
              </ol>
            </td>
            <td width="20%">
              <?php
              $myone = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='one' AND Emp_ID='" . $_SESSION['EmpID'] . "'LIMIT 1");
              $rone = mysqli_fetch_assoc($myone);
              ?>

              <input id="oneyes" type="radio" name="one" value="Yes" <?php echo SetRadioButtonChecked($rone['Answer'] === 'Yes'); ?> required>
              <label for="oneyes" class="p-2">Yes</label>

              <input id="oneno" type="radio" name="one" value="No" <?php echo SetRadioButtonChecked($rone['Answer'] === 'No'); ?> required>
              <label for="oneno" class="p-2">No</label>

              <div class="form-group">
                <label for="one_details">If YES, give details:</label>
                <input id="one_details" type="text" name="one_details" class="form-control" value="<?php echo $rone['Details']; ?>">
              </div>

              <hr>

              <?php
              $mytwo = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='two' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rtwo = mysqli_fetch_assoc($mytwo);
              if ($rtwo['Answer'] == 'Yes') {
                echo '<input type="radio" name="two" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" value="' . $rtwo['Details'] . '" class="form-control"></label>';
              } elseif ($rtwo['Answer'] == 'No') {
                echo '<input type="radio" name="two" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="two" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="two" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="two_details" class="form-control"></label>';
              }
              ?>
            </td>

          </tr>

          <tr>
            <td>
              <p> <b style="padding:8px;">37. </b> a. Have you been formally charged?</p><br /><br /><br /><br />
              <hr />
              <p style="padding:8px;">b. Have you been guilty of any administrative offense?</p>
            </td>
            <td width="20%">
              <?php
              $mythree = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='three' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rthree = mysqli_fetch_assoc($mythree);
              if ($rthree['Answer'] == 'Yes') {
                echo '<input type="radio" name="three" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" value="' . $rthree['Details'] . '" class="form-control"></label>';
              } elseif ($rthree['Answer'] == 'No') {
                echo '<input type="radio" name="three" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="three" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="three" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="three_details" class="form-control"></label>';
              }
              echo '<hr>';

              $myfour = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='four' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rfour = mysqli_fetch_assoc($myfour);
              if ($rfour['Answer'] == 'Yes') {
                echo '<input type="radio" name="four" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" value="' . $rfour['Details'] . '" class="form-control"></label>';
              } elseif ($rfour['Answer'] == 'No') {
                echo '<input type="radio" name="four" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="four" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="four" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="four_details" class="form-control"></label>';
              }
              ?>
            </td>

          </tr>
          <tr>
            <td>
              38. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
            </td>
            <th width="20%">
              <?php
              $myfive = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='five' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rfive = mysqli_fetch_assoc($myfive);
              if ($rfive['Answer'] == 'Yes') {
                echo '<input type="radio" name="five" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" value="' . $rfive['Details'] . '" class="form-control"></label>';
              } elseif ($rfive['Answer'] == 'No') {
                echo '<input type="radio" name="five" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="five" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="five" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="five_details" class="form-control"></label>';
              }
              ?>



            </th>

          </tr>
          <tr>
            <td>
              39. Have you ever been separated from the service in any of the following modes: resignation retirement, dropped from the rolls, dismissal, termination, end of term, finished contract, AWOL or phased out, in the public or private sector? <br /><br /><br />

            </td>
            <td width="20%">
              <br /><br />
              <?php
              $mysix = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='six' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rsix = mysqli_fetch_assoc($mysix);
              if ($rsix['Answer'] == 'Yes') {
                echo '<input type="radio" name="six" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No" required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" value="' . $rsix['Details'] . '" class="form-control"></label>';
              } elseif ($rsix['Answer'] == 'No') {
                echo '<input type="radio" name="six" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No" checked required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="six" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="six" value="No"  required ><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="six_details" class="form-control"></label>';
              }

              ?>
            </td>

          </tr>





          <tr>
            <td>
              40. Have you ever been a candidate in a national or local election (except Barangay election)? <br /><br /><br />

            </td>
            <td width="20%">
              <br /><br />

              <?php
              $myeight = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='seven' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $reight = mysqli_fetch_assoc($myeight);
              if ($reight['Answer'] == 'Yes') {
                echo '<input type="radio" name="seven" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" value="' . $reight['Details'] . '"class="form-control"></label>';
              } elseif ($reight['Answer'] == 'No') {
                echo '<input type="radio" name="seven" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="seven" value="Yes"  required><label style="padding:10px;">YES</label>
							<input type="radio" name="seven" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="seven_details" class="form-control"></label>';
              }


              ?>
            </td>

          </tr>
          <tr>
            <td>
              41. Pursuant to (a) indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and © Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items: <br /><br /><br />
              a. Are you a member of any indigenous group?<br /><br /><br />
              b. Are you differently abled?<br /><br /><br />
              c. Are you a solo parent?<br /><br /><br />
              </th>
            <td width="20%">
              <?php
              $myten = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='eight' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rten = mysqli_fetch_assoc($myten);
              if ($rten['Answer'] == 'Yes') {
                echo '<input type="radio" name="eight" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name=" eight_details" value="' . $rten['Details'] . '" class="form-control"></label>';
              } elseif ($rten['Answer'] == 'No') {
                echo '<input type="radio" name="eight" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name=" eight_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="eight" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="eight" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="eight_details" class="form-control"></label>';
              }


              echo '<br/></hr/>';

              $myeleven = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='nine' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $releven = mysqli_fetch_assoc($myeleven);
              if ($releven['Answer'] == 'Yes') {
                echo '<input type="radio" name="nine" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No" required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" value="' . $releven['Details'] . '" class="form-control"></label>';
              } elseif ($releven['Answer'] == 'No') {
                echo '<input type="radio" name="nine" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="nine" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="nine" value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="nine_details" class="form-control"></label>';
              }
              echo '<br/></hr/>';

              $mytweve = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='ten' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rtweve = mysqli_fetch_assoc($mytweve);
              if ($rtweve['Answer'] == 'Yes') {
                echo '<input type="radio" name="ten" value="Yes" checked required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" value="' . $rtweve['Details'] . '" class="form-control"></label>';
              } elseif ($rtweve['Answer'] == 'No') {
                echo '<input type="radio" name="ten" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No" checked required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" class="form-control"></label>';
              } else {
                echo '<input type="radio" name="ten" value="Yes" required><label style="padding:10px;">YES</label>
							<input type="radio" name="ten"  value="No"  required><label style="padding:10px;">NO</label>
							<label>If YES, give details:<br/><input type="text" name="ten_details" class="form-control"></label>';
              }
              ?>
            </td>
          </tr>
        </tbody>
      </table>

      <input type="submit" name="SaveAnswers" value="Save" class="btn btn-primary float-right">
    </div><!-- .col -->
  </form>
</div>