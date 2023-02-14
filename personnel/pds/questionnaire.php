<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'questionnaires'); ?>" id="questionnaires">
  <div class="d-sm-flex justify-content-between my-3">
    <h3 class="h4 mb-0">Other Information</h3>
  </div>

  <form class="row mt-3" action="" Method="POST" enctype="multipart/form-data">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered mb-0">
        <tbody>
          <tr>
            <td width="80%">
              <p>Are you related by sanguinity or affinity to any of the following:</p>
              <ol type="a" class="mt-3">
                <li class="pb-5">Within the third degree (by National Government Employees):
                  appointing authority, recommending authority, chief of office/bureau/department of person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed?</li>
                <li class="pt-5">Within the fourth degree (for Local Government Employees): appointing authority or recommending authority where you will be appointed?</li>
              </ol>
            </td>

            <td width="20%">
              <div class="pt-5">
                <?php
                $myone = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='one' AND Emp_ID='" . $_SESSION['EmpID'] . "'LIMIT 1");
                $rone = mysqli_fetch_assoc($myone);
                ?>

                <input id="oneyes" type="radio" name="one" value="Yes" <?php echo SetRadioButtonChecked($rone['Answer'] === 'Yes'); ?> required>
                <label for="oneyes" class="px-1 mr-3">YES</label>

                <input id="oneno" type="radio" name="one" value="No" <?php echo SetRadioButtonChecked($rone['Answer'] === 'No'); ?> required>
                <label for="oneno" class="px-1">NO</label>

                <div class="form-group">
                  <label for="one_details">If YES, give details:</label>
                  <input id="one_details" type="text" name="one_details" value="<?php echo $rone['Details']; ?>" class="form-control"></label>
                </div>

                <hr>

                <?php
                $mytwo = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='two' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
                $rtwo = mysqli_fetch_assoc($mytwo);
                ?>

                <input id="twoyes" type="radio" name="two" value="Yes" <?php echo SetRadioButtonChecked($rtwo['Answer'] === 'Yes'); ?> required>
                <label for="twoyes" class="px-1 mr-3">YES</label>

                <input id="twono" type="radio" name="two" value="No" <?php echo SetRadioButtonChecked($rtwo['Answer'] === 'No'); ?> required>
                <label for="twono" class="px-1">NO</label>

                <div class="form-group mb-0">
                  <label for="two_details">If YES, give details:</label>
                  <input id="two_details" type="text" name="two_details" value="<?php echo $rtwo['Details']; ?>" class="form-control"></label>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="80%">
              <ol type="a" class="pl-3">
                <li class="pb-5">Have you been formally charged?</li>
                <li class="pt-5 mt-3">Have you been guilty of any administrative offense?</li>
              </ol>
            </td>

            <td width="20%">
              <?php
              $mythree = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='three' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rthree = mysqli_fetch_assoc($mythree);
              ?>

              <input id="threeyes" type="radio" name="three" value="Yes" <?php echo SetRadioButtonChecked($rthree['Answer'] === 'Yes'); ?> required>
              <label for="threeyes" class="px-1 mr-3">YES</label>

              <input id="threeno" type="radio" name="three" value="No" <?php echo SetRadioButtonChecked($rthree['Answer'] === 'No'); ?> required>
              <label for="threeno" class="px-1">NO</label>

              <div class="form-group">
                <label for="three_details">If YES, give details:</label>
                <input id="three_details" type="text" name="three_details" value="<?php echo $rthree['Details']; ?>" class="form-control"></label>
              </div>

              <hr>

              <?php
              $myfour = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='four' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rfour = mysqli_fetch_assoc($myfour);
              ?>

              <input id="fouryes" type="radio" name="four" value="Yes" <?php echo SetRadioButtonChecked($rfour['Answer'] === 'Yes'); ?> required>
              <label for="fouryes" class="px-1 mr-3">YES</label>

              <input id="fourno" type="radio" name="four" value="No" <?php echo SetRadioButtonChecked($rfour['Answer'] === 'No'); ?> required>
              <label for="fourno" class="px-1">NO</label>

              <div class="form-group mb-0">
                <label for="four_details">If YES, give details:</label>
                <input id="four_details" type="text" name="four_details" value="<?php echo $rfour['Details']; ?>" class="form-control"></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="80%">
              <p>Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</p>
            </td>

            <td width="20%">
              <?php
              $myfive = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='five' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rfive = mysqli_fetch_assoc($myfive); ?>

              <input id="fiveyes" type="radio" name="five" value="Yes" <?php echo SetRadioButtonChecked($rfive['Answer'] === 'Yes'); ?> required>
              <label for="fiveyes" class="px-1 mr-3">YES</label>

              <input id="fiveno" type="radio" name="five" value="No" <?php echo SetRadioButtonChecked($rfive['Answer'] === 'No'); ?> required>
              <label for="fiveno" class="px-1">NO</label>

              <div class="form-group mb-0">
                <label for="five_details">If YES, give details:</label>
                <input id="five_details" type="text" name="five_details" value="<?php echo $rfive['Details']; ?>" class="form-control"></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="80%">
              <p>Have you ever been separated from the service in any of the following modes: resignation retirement, dropped from the rolls, dismissal, termination, end of term, finished contract, AWOL or phased out, in the public or private sector?</p>
            </td>

            <td width="20%">
              <?php
              $mysix = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='six' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $rsix = mysqli_fetch_assoc($mysix); ?>

              <input id="sixyes" type="radio" name="six" value="Yes" <?php echo SetRadioButtonChecked($rsix['Answer'] === 'Yes'); ?> required>
              <label for="sixyes" class="px-1 mr-3">YES</label>

              <input id="sixno" type="radio" name="six" value="No" <?php echo SetRadioButtonChecked($rsix['Answer'] === 'No'); ?> required>
              <label for="sixno" class="px-1">NO</label>

              <div class="form-group mb-0">
                <label for="six_details">If YES, give details:</label>
                <input id="six_details" type="text" name="six_details" value="<?php echo $rsix['Details']; ?>" class="form-control"></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="80%">
              <p>Have you ever been a candidate in a national or local election (except Barangay election)?</p>
            </td>

            <td width="20%">
              <?php
              $myeight = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='seven' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
              $reight = mysqli_fetch_assoc($myeight); ?>

              <input id="sevenyes" type="radio" name="seven" value="Yes" <?php echo SetRadioButtonChecked($reight['Answer'] === 'Yes'); ?> required>
              <label for="sevenyes" class="px-1 mr-3">YES</label>

              <input id="sevenno" type="radio" name="seven" value="No" <?php echo SetRadioButtonChecked($reight['Answer'] === 'No'); ?> required>
              <label for="sevenno" class="px-1">NO</label>

              <div class="form-group mb-0">
                <label for="seven_details">If YES, give details:</label>
                <input id="seven_details" type="text" name="seven_details" value="<?php echo $reight['Details']; ?>" class="form-control"></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="80%">
              <p>Pursuant to (a) indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items:</p>

              <ol type="a" class="mt-3">
                <li class="pb-5">Are you a member of any indigenous group?</li>
                <li class="py-5">Are you differently abled?</li>
                <li class="pt-5">Are you a solo parent?</li>
              </ol>
            </td>

            <td width="20%">
              <div class="pt-5">
                <?php
                $myten = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='eight' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
                $rten = mysqli_fetch_assoc($myten); ?>

                <input id="eightyes" type="radio" name="eight" value="Yes" <?php echo SetRadioButtonChecked($rten['Answer'] === 'Yes'); ?> required>
                <label for="eightyes" class="px-1 mr-3">YES</label>

                <input id="eightno" type="radio" name="eight" value="No" <?php echo SetRadioButtonChecked($rten['Answer'] === 'No'); ?> required>
                <label for="eightno" class="px-1">NO</label>

                <div class="form-group">
                  <label for="eight_details">If YES, give details:</label>
                  <input id="eight_details" type="text" name="eight_details" value="<?php echo $rten['Details']; ?>" class="form-control"></label>
                </div>

                <hr>

                <?php
                $myeleven = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='nine' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
                $releven = mysqli_fetch_assoc($myeleven); ?>

                <input id="nineyes" type="radio" name="nine" value="Yes" <?php echo SetRadioButtonChecked($releven['Answer'] === 'Yes'); ?> required>
                <label for="nineyes" class="px-1 mr-3">YES</label>

                <input id="nineno" type="radio" name="nine" value="No" <?php echo SetRadioButtonChecked($releven['Answer'] === 'No'); ?> required>
                <label for="nineno" class="px-1">NO</label>

                <div class="form-group">
                  <label for="nine_details">If YES, give details:</label>
                  <input id="nine_details" type="text" name="nine_details" value="<?php echo $releven['Details']; ?>" class="form-control"></label>
                </div>

                <hr>

                <?php
                $mytweve = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='ten' AND Emp_ID='" . $_SESSION['EmpID'] . "'limit 1");
                $rtweve = mysqli_fetch_assoc($mytweve); ?>

                <input id="tenyes" type="radio" name="ten" value="Yes" <?php echo SetRadioButtonChecked($rtweve['Answer'] === 'Yes'); ?> required>
                <label for="tenyes" class="px-1 mr-3">YES</label>

                <input id="tenno" type="radio" name="ten" value="No" <?php echo SetRadioButtonChecked($rtweve['Answer'] === 'No'); ?> required>
                <label for="tenno" class="px-1">NO</label>

                <div class="form-group">
                  <label for="ten_details">If YES, give details:</label>
                  <input id="ten_details" type="text" name="ten_details" value="<?php echo $rtweve['Details']; ?>" class="form-control"></label>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="submit" name="SaveAnswers" class="btn btn-primary btn-block form-control mt-3"><i class="fas fa-save fa-fw"></i> Update Other Information</button>
    </div><!-- .col -->
  </form>
</div>