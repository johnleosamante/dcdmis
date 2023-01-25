<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'other-information'); ?>" id="other-information">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Other Information</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-other-information.php?id=')" data-toggle="modal" data-target="#Modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="30%">Special Skills &amp; Hobbies</th>
            <th class="align-middle" width="30%">Non-Academic Distinctions / Recognition</th>
            <th class="align-middle" width="30%">Membership in Association / Organization</th>
            <th class="align-middle" width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $informations = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($informations) > 0) {
            while ($information = mysqli_fetch_array($informations)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $information['Special_Skills']; ?></td>
                <td class="text-center align-middle"><?php echo $information['Recognation']; ?></td>
                <td class="text-center align-middle"><?php echo $information['Organization']; ?></td>

                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-other-information.php?id=<?php echo $information['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-other-information.php?id=<?php echo $information['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="4">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->