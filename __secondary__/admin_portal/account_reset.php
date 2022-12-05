<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="" class="btn btn-primary" style="float:right;">Print Report</a>

        <h4>Request for Reset DepEd Account Masterlist</h4>

        <?php
        if (isset($_POST['saverequest'])) {
          mysqli_query($con, "UPDATE tbl_deped_reset_account SET Remarks='" . $_POST['actiontaken'] . "' WHERE TicketNo='" . $_SESSION['curticket'] . "' LIMIT 1");
          mysqli_query($con, "INSERT INTO tbl_deped_reset_account_logs VALUES(NULL,'" . date("Y-m-d") . "','" . $_POST['tempPassword'] . "','" . $_SESSION['curticket'] . "')");

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
      </div>

      <!-- /.panel-heading -->
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th width="5%" style="text-align:center;">Ticket #</th>
              <th width="20%">Name</th>
              <th width="20%">Deped Email</th>
              <th>School</th>
              <th>Contact No</th>
              <th>Remarks</th>
              <th width="5%"></th>
            </tr>
          </thead>

          <tbody>
            <?php
            $no = 0;
            $result = mysqli_query($con, "SELECT * FROM tbl_deped_reset_account INNER JOIN tbl_school ON tbl_deped_reset_account.SchoolID=tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_deped_reset_account.Emp_ID = tbl_employee.Emp_ID ORDER BY tbl_deped_reset_account.Emp_ID Asc");

            while ($row = mysqli_fetch_array($result)) { ?>
              <tr>
                <td style="text-align:center;"><?php echo $row['TicketNo']; ?></td>
                <td><?php echo strtoupper($row['Emp_LName'] . ', ' . $row['Emp_FName']); ?></td>
                <td><?php echo $row['depedemail']; ?></td>
                <td><?php echo $row['SchoolName']; ?></td>
                <td><?php echo $row['ContactNo']; ?></td>
                <td><?php echo $row['Remarks']; ?></td>
                <td>
                  <a href="view_account_info.php?id=<?php echo $row['TicketNo']; ?>" data-toggle="modal" data-target="#viewinfo" title="View Information" class="btn btn-info">
                    <i class="fa fa-desktop fa-fw"></i>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div><!-- /.panel-body -->
    </div><!-- /.panel -->
  </div><!-- /.col-lg-12 -->
</div>

<!-- Modal for Re-assign-->
<div class="panel-body">
  <div class="modal fade" id="viewinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      </div><!-- Modal content-->
    </div><!-- Modal dialog-->
  </div><!-- Modal -->
</div>