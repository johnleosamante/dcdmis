<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'children'); ?>" id="children">
  <div class="d-sm-flex justify-content-between my-3">
    <h3 class="h4 mb-0">Children</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-child.php?id=')" data-target="#Modal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th width="70%">Name of Children</th>
            <th width="20%">Date of Birth</th>
            <th width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $children = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY Birthdate DESC;");

          if (mysqli_num_rows($children) > 0) {
            while ($child = mysqli_fetch_array($children)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo ToName($child['Family_Name'], $child['First_Name'], $child['Middle_Name'], $child['Name_Extension'], true); ?></td>
                <td class="text-center align-middle"><?php echo ToLongDateString($child['Birthdate']); ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-child.php?id=<?php echo $child['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-child.php?id=<?php echo $child['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="3">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>