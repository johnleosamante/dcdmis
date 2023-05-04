<?php
// includes/database/family-background.php

function family($id) {
  return query("SELECT Emp_ID AS id, SpouseLast AS slast, SpouseFirst AS sfirst, SpouseMiddle AS smiddle, SpouseExtension AS sext, SpouseOccupation AS swork, SpouseBusiness AS soffice, SpouseBusinessAddress AS soffice_addres, SpouseTelephone AS stelephone, FatherLast AS flast, FatherFirst AS ffirst, FatherExtension AS fext, FatherMiddle AS fmiddle, MotherLast AS mlast, MotherFirst AS mfirst, MotherMiddle AS mmiddle FROM tbl_family_background WHERE Emp_id='{$id}' LIMIT 1;");
}
?>