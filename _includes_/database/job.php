<?php
# _includes_/database/job.php

function GetJob() {
  return DBQuery("SELECT Job_code AS id, Job_description AS `name` FROM tbl_job ORDER BY Job_description;");
}
?>