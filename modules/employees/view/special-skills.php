<?php
// modules/employees/view/special-skills.php
?>

<div class="tab-pane fade" id="special-skills">
  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle">Special Skills &amp; Hobbies</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $skills = special_skill($employee['id']);

          if (num_rows($skills) > 0) {
            while ($skill = fetch_assoc($skills)) : ?>
              <tr>
                <td class="align-middle"><?php echo $skill['skill']; ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->