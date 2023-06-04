<?php
// modules/employees/view/membership.php
?>

<div class="tab-pane fade<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'membership', 'show active'); ?>" id="membership">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="90%">Membership in Association / Organization</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $organizations = memberships($employee['id']);

          if (numRows($organizations) > 0) {
            while ($membership = fetchAssoc($organizations)) : ?>
              <tr>
                <td class="align-middle"><?php echo $membership['organization']; ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td class="align-middle" colspan="1">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->