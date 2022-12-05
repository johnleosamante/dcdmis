<div class="row">
  <div class="col-lg-8">
    <div class="panel panel-default">

      <?php
      if (isset($_POST['save_question'])) {
        $PageNo = 1;

        $save = mysqli_query($con, "SELECT * FROM tbl_written_work_set_activity WHERE SubCode='" . $_SESSION['SubCode'] . "' AND SYCode='" . $_SESSION['year'] . "' AND Quarter='" . $_SESSION['Quarter'] . "' AND Name_of_activity='" . $_GET['Type'] . "' AND Grade_Level='" . $_SESSION['Grade_Level'] . "' AND ModuleCode='" . $_SESSION['Access'] . "' AND QCode='" . $_GET['Act_Code'] . "'");
        $rowsave = mysqli_fetch_assoc($save);

        //Query the data
        $queryans = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $rowsave['QCode'] . "'");

        if (mysqli_num_rows($queryans) == 0) {

          while ($PageNo <= $rowsave['ItemNo']) {

            $Ans = $_POST[$PageNo];
            $Ans = str_replace("'", "\'", $Ans);
            mysqli_query($con, "INSERT INTO tbl_activity_sheets VALUES (NULL,'" . $_SESSION['SubCode'] . "','" . $rowsave['QCode'] . "','" . $PageNo . "','" . $Ans . "','-','0','')");
            $PageNo++;
          }
        } else {
          while ($PageNo <= $rowsave['ItemNo']) {
            $Ans = $_POST[$PageNo];
            $Ans = str_replace("'", "\'", $Ans);
            mysqli_query($con, "UPDATE tbl_activity_sheets SET Activity_question='" . $Ans . "' WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $rowsave['QCode'] . "' AND Activity_No='" . $PageNo . "' LIMIT 1");
            $PageNo++;
          }
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
      ?>

      <!-- /.panel-heading -->
      <div class="panel-body">
        <?php
        $myimage = mysqli_query($con, "SELECT * FROM tbl_list_of_module_activity WHERE tbl_list_of_module_activity.SubCode='" . $_SESSION['SubCode'] . "' AND tbl_list_of_module_activity.ModuleCode ='" . $_SESSION['Access'] . "' AND Grade_Level='" . $_SESSION['Grade_Level'] . "'  AND Quarter='" . $_SESSION['Quarter'] . "' LIMIT 1");
        $rowimage = mysqli_fetch_assoc($myimage);
        echo '<iframe src="../../pcdmis/reading_materials/' . $rowimage['Module_location'] . '" frameborder="0" style="width:100%;height:700px;"></iframe>';

        ?>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>

  <div class="col-lg-4">
    <div class="panel panel-default">
      <?php
      $_SESSION['Activity_Code'] = $_GET['Act_Code'];
      $record = mysqli_query($con, "SELECT * FROM tbl_written_work_set_activity WHERE SubCode='" . $_SESSION['SubCode'] . "' AND SYCode='" . $_SESSION['year'] . "' AND Quarter='" . $_SESSION['Quarter'] . "' AND Name_of_activity='" . $_GET['Type'] . "' AND Grade_Level='" . $_SESSION['Grade_Level'] . "' AND ModuleCode='" . $_SESSION['Access'] . "' AND QCode='" . $_GET['Act_Code'] . "'");
      $row = mysqli_fetch_assoc($record);
      echo '<div class="panel-heading">
                        
              <h4 style="text-transform:uppercase;"><i class="fa fa-check"></i><b>' . $row['Type_of_activity'] . ' (' . $_GET['Type'] . ')</b></h4>
                 
             </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">';

      if (mysqli_num_rows($record) == 0) {
        echo '<form action ="" method="POST" enctype="multipart/form-data"> 
                      
                      <input type="hidden" name="Activity" class="form-control" value = "' . $_GET['Type'] . '"placeholder="Activity Name">
                      <label>Title of Activity:</label>
                      <input type="text" name="activityTitle" class="form-control" placeholder="Type of Activity"><br/>
                      <label>Item No:</label>
                      <input type="text" name="ItemNo" class="form-control" placeholder="Number of Item"><br/>
                      <input type="submit" name="newactivity"  style="float:right;" value="Next" class="btn btn-primary">
                      
                      </form>';
      } else {
        $PageNo = 1;
        $_SESSION['ItemNo'] = $row['ItemNo'];
        echo '<a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&QNo=' . urlencode(base64_encode($PageNo)) . '&m=' . urlencode(base64_encode($row['QCode'])) . '&v=' . urlencode(base64_encode("addoption")) . '" class="btn btn-info" style="float:right;">Add Option</a>';
        echo '<a href="remove_activity.php?code=' . urlencode(base64_encode($row['QCode'])) . '" class="btn btn-info">Remove Activity</a><hr/>';

        echo '<form action ="" method="POST" enctype="multipart/form-data">';

        while ($PageNo <= $row['ItemNo']) {
          $query = mysqli_query($con, "SELECT * FROM tbl_activity_sheets WHERE SubCode='" . $_SESSION['SubCode'] . "' AND Activity_Code='" . $row['QCode'] . "' AND Activity_No='" . $PageNo . "'");
          $rowquery = mysqli_fetch_assoc($query);
          echo '<div class="form-group input-group">
                        <span class="input-group-addon">' . $PageNo . '.</span>
                              <input type="text" name="' . $PageNo . '" class="form-control" value="' . $rowquery['Activity_question'] . '" placeholder="Question for number ' . $PageNo . '" required>
                        </div>';
          $PageNo++;
        }
        echo '<hr/>
                          <a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access=' . urlencode(base64_encode($_SESSION['Access'])) . '&Item=' . urlencode(base64_encode("1")) . '&v=' . urlencode(base64_encode("addreadingmaterial")) . '" class="btn btn-secondary">Back to Course</a>
                        <input type="submit" name="save_question" value="SUBMIT" class="btn btn-primary" style="float:right;"></form>';
      }


      if ($_SESSION['Grade_Level'] >= 1 and  $_SESSION['Grade_Level'] <= 6) {
        $areas = mysqli_query($con, "SELECT * FROM tbl_element_subject WHERE SubNo='" . $_SESSION['SubCode'] . "' ORDER BY SubNo Desc");
      } elseif ($_SESSION['Grade_Level'] >= 7 and  $_SESSION['Grade_Level'] <= 10) {
        $areas = mysqli_query($con, "SELECT * FROM tbl_jhs_subject WHERE SubNo='" . $_SESSION['SubCode'] . "' ORDER BY LearningAreas Asc");
      } elseif ($_SESSION['Grade_Level'] >= 11 and  $_SESSION['Grade_Level'] <= 12) {
        $areas = mysqli_query($con, "SELECT * FROM tbl_senior_sub_strand WHERE SubGradeLevel='" . $_SESSION['Grade_Level'] . "' AND StrandsubCode='" . $_SESSION['SubCode'] . "'ORDER BY StrandsubCode Asc");
      }
      $rowdata = mysqli_fetch_assoc($areas);
      echo '<br/><hr/><label>Grade Level and Learning Areas:</label><br/>';
      if ($_SESSION['Grade_Level'] == 11 || $_SESSION['Grade_Level'] == 12) {
        echo '<label>Grade ' . $_SESSION['Grade_Level'] . ' - ' . $rowdata['SubStrandDescription'] . '<br/>(' . $_SESSION['Quarter'] . ' Quarter)</label>';
      } else {
        echo '<label>Grade ' . $_SESSION['Grade_Level'] . ' - ' . $rowdata['LearningAreas'] . '<br/>(' . $_SESSION['Quarter'] . ' Quarter)</label>';
      }
      ?>

    </div>
    <!-- /.panel-body -->
  </div>
  <!-- /.panel -->
</div>