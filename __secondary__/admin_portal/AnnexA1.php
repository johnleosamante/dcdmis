<style>
  td {
    text-transform: uppercase;
  }
</style>

<!-- /.col-lg-12 -->
<div class="col-lg-12">
  <h1></h1>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <?php
        echo ' <a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=' . urlencode(base64_encode($_SESSION['current_id'])) . '&v=' . urlencode(base64_encode("asds_report")) . '" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>';
        ?>

        <h4>SEMI-EXPENDABLE PROPERTY CARD (ANNEX A1)<h4>
      </div><!-- /.panel-heading -->

      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th width="15%" style="text-align:center;">Fund Cluster</th>
              <th>Description</th>
              <th width="15%" style="text-align:center;">Semi-expendable Property</th>
              <th width="15%" style="text-align:center;">Semi-expendable Property-Number</th>
              <th width="7%" style="text-align:center;"></th>
            </tr>
          </thead>

          <tbody>
            <?php
            $no = 0;
            $result = mysqli_query($con, "SELECT * FROM tbl_sep_annexa1 WHERE SEP_SchoolID ='" . $_SESSION['current_id'] . "' ORDER BY CardCode Desc");
            while ($row = mysqli_fetch_array($result)) {
              $no++; ?>

            <tr>
              <td style="text-align:center;"><?php echo $no; ?></td>
                <td style="text-align:center;"><?php echo $row['Fund_cluster']; ?></td>
                <td><?php echo $row['SEP_Description']; ?></td>
                <td style="text-align:center;"><?php echo $row['SEP']; ?></td>
                <td style="text-align:center;"><?php echo $row['SEPNo']; ?></td>
                <td style="text-align:center;"><a href="print_annexa1.php?code=<?php echo urlencode(base64_encode($row['CardCode'])); ?>" target="blank">VIEW</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div><!-- /.panel-body -->
    </div><!-- /.panel -->
  </div>
</div>