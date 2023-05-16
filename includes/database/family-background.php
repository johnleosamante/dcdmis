<?php
// includes/database/family-background.php

function family($id) {
  return query("SELECT Emp_ID AS id, SpouseLast AS slast, SpouseFirst AS sfirst, SpouseMiddle AS smiddle, SpouseExtension AS sext, SpouseOccupation AS swork, SpouseBusiness AS soffice, SpouseBusinessAddress AS soffice_address, SpouseTelephone AS stelephone, FatherLast AS flast, FatherFirst AS ffirst, FatherExtension AS fext, FatherMiddle AS fmiddle, MotherLast AS mlast, MotherFirst AS mfirst, MotherMiddle AS mmiddle FROM tbl_family_background WHERE Emp_id='{$id}' LIMIT 1;");
}

function create_family($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $id) {
  non_query("INSERT INTO tbl_family_background (Emp_ID, SpouseLast, SpouseFirst, SpouseMiddle, SpouseExtension, SpouseOccupation, SpouseBusiness, SpouseBusinessAddress, SpouseTelephone, FatherLast, FatherFirst, FatherExtension, FatherMiddle, MotherLast, MotherFirst, MotherMiddle) VALUES ('{$id}', '{$slast}', '{$sfirst}', '{$smiddle}', '{$sext}', '{$swork}', '{$sbusiness}', '{$sbusiness_address}', '{$stelephone}', '{$flast}', '{$ffirst}', '{$fext}', '{$fmiddle}', '{$mlast}', '{$mfirst}', '{$mmiddle}');");
}

function update_family($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $id) {
  non_query("UPDATE tbl_family_background SET SpouseLast='{$slast}', SpouseFirst='{$sfirst}', SpouseExtension='{$sext}', SpouseMiddle='{$smiddle}', SpouseOccupation='{$swork}', SpouseBusiness='{$sbusiness}', SpouseBusinessAddress='{$sbusiness_address}', SpouseTelephone='{$stelephone}', FatherLast='{$flast}', FatherFirst='{$ffirst}', FatherExtension='{$fext}', FatherMiddle='{$fmiddle}', MotherLast='{$mlast}', MotherFirst='{$mfirst}', MotherMiddle='{$mmiddle}' WHERE Emp_ID='{$id}' LIMIT 1;");
}
?>