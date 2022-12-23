<?php
# _includes_/database/school.php

function GetSchool() {
  return DBQuery("SELECT SchoolID AS id, SchoolName AS `name` FROM tbl_school ORDER BY SchoolName ASC;");
}
?>