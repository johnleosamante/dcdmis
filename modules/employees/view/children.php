<?php
// modules/employees/view/children.php
?>

<div class="tab-pane fade" id="children">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center" cellspacing="0">
        <thead>
          <tr>
            <th width="70%">Name of Child</th>
            <th widht="30%">Date of Birth</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $children = children($employee['id']);

          if (num_rows($children) > 0) {
            while ($child = fetch_assoc($children)) : ?>
              <tr>
                <td class="align-middle"><?php echo to_name($child['last'], $child['first'], $child['middle'], $child['ext']); ?></td>
                <td class="align-middle"><?php echo to_date($child['dob']); ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="3" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->